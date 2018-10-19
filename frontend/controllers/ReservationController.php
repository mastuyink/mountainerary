<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\TTrip;
use common\models\TNationality;
use common\models\TPassenger;
use common\models\TCurrency;
use common\models\Model;
use common\models\TBooking;
use common\models\TShuttleArea;
use common\models\TShuttle;
use common\models\TPaymentMethod;
use app\models\Reservation;
use app\models\BookingForm;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use kartik\mpdf\Pdf;
/**
 * Site controller
 */
class ReservationController extends Controller
{

    public function actionBookNow(){
        $modelBookingForm = new BookingForm(); 
        if ($modelBookingForm->load(Yii::$app->request->post())) {
            if ($modelBookingForm->validate()) {
                $session = Yii::$app->session;
                $session['reservation'] = [
                    'id_trip'   => $modelBookingForm->id_trip,
                    'trip_date' => $modelBookingForm->trip_date,
                    'adults'    => $modelBookingForm->adults,
                    'childs'    => $modelBookingForm->childs
                ];
                return $this->redirect(['/reservation/fill-detail']);
            }else{
                Yii::$app->session->setFlash('danger', 'Unable to validate Your Input');
            }
        }
        return $this->goHome();
    }
    public function actionChangeCurrency(){
        if (Yii::$app->request->isAjax) {
            $session = Yii::$app->session;
            $selectedCurrency = Yii::$app->request->post('currency', NULL);
            if (in_array($selectedCurrency, Yii::$app->params['currencyList'])) {
                $session['currency'] = $selectedCurrency;
            }else{
                $session['currency'] = 'IDR';
            }
            return true;
        }else{
            return $this->goHome();
        }
    }
    public function actionCalcPrice($id_trip){
        if (Yii::$app->request->isAjax) {
            $data     = Yii::$app->request->post();
            $session  = Yii::$app->session;
            $trip     = $this->findOneTrip($id_trip);
            $session = Yii::$app->session;
            if ($session['currency'] == NULL) {
                $currentCurrency = 'USD';
            }else{
                $currentCurrency = $session['currency'];
            }
            $currency = $this->getCurrency($currentCurrency);
             if ($data['adults']+$data['childs'] <= $trip['min_pax']) {
                    $totalPricesIdr = $trip['price_min'];
                    $totalPrices     = round($totalPricesIdr/$currency['kurs'],2,PHP_ROUND_HALF_UP);
            }else{
                if ($data['adults'] >= $trip['min_pax'] && $data['childs'] > 0) {
                    $extraAdult         = $data['adults']-$trip['min_pax'];
                    $extraChild         = $data['childs'];
                    $extraPriceAdultIdr = $extraAdult*$trip['price_pax_adult'];
                    $extraPriceChildIdr = $extraChild*$trip['price_pax_child'];
                    $extraPriceIdr      = $extraPriceAdultIdr+$extraPriceChildIdr;
                    $extraPrice         = round($extraPriceIdr/$currency['kurs'],0,PHP_ROUND_HALF_UP);

                }else{
                    $extraPax      = $data['adults']+$data['childs']-$trip['min_pax'];
                    $extraPriceIdr = $extraPax*$trip['price_pax_adult'];
                    $extraPrice    = round($extraPriceIdr/$currency['kurs'],0,PHP_ROUND_HALF_UP);
                }

                $basePriceIdr   = $trip['price_min'];
                $basePrice      = round($basePriceIdr/$currency['kurs'],0,PHP_ROUND_HALF_UP);
                $totalPricesIdr = $basePriceIdr+$extraPriceIdr;
                $totalPrices    = $extraPrice+$basePrice;

            }
            $prices = [
                    'total_price'     => number_format($totalPrices,0),
                    'total_price_idr' => number_format($totalPricesIdr,0),
                    'currency' => $currency['currency'],
                ];

                    return json_encode($prices);
        }else{
            return $this->goHome();
        }
    }
    public function actionFillDetail(){
        $listNationoality = ArrayHelper::map(TNationality::getNationality(), 'id', 'nationality');
        $session          = Yii::$app->session;
        $trip             = $this->findOneTrip($session['reservation']['id_trip']);
        $modelReservation       = new Reservation();
        $modelPasengers   = new TPassenger();
        $package          = [
            'adults'=> $session['reservation']['adults'],
            'childs' => $session['reservation']['childs']
        ];
        $modelReservation->trip_date = $session['reservation']['trip_date'];
        $modelReservation->id_trip   = $trip['id'];
        $currency              = $this->getCurrency(isset($session['currency']) ? $session['currency'] : 'USD');
        if ($modelReservation->load(Yii::$app->request->post()) && $modelReservation->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($package['adults']+$package['childs'] <= $trip['min_pax']) {
                    $totalPricesIdr = $trip['price_min'];
                    $totalPrice     = round($totalPricesIdr/$currency['kurs'],2,PHP_ROUND_HALF_UP);
                }else{
                    $adultPricesIdr = $package['adults']*$trip['price_pax_adult'];
                    $adultPrices    = round($adultPricesIdr/$currency['kurs'],2,PHP_ROUND_HALF_UP);
                    if ($package['childs'] > 0) {
                        $childPricesIdr = $package['childs']*$trip['price_pax_child'];
                        $childPrices    = round($childPricesIdr/$currency['kurs'],2,PHP_ROUND_HALF_UP);
                    }else{
                        $childPrices    = 0;
                        $childPricesIdr = 0;
                    }
                    $totalPrice     = $adultPrices+$childPrices;
                    $totalPricesIdr = $adultPricesIdr+$childPricesIdr;
                }
                
                $modelReservation->id           = $modelReservation->generateCode("id",5);
                $modelReservation->token        = $modelReservation->generateCode("token",10);
                $modelReservation->id_currency  = $currency['currency'];
                $modelReservation->amount       = $totalPrice;
                $modelReservation->amount_idr   = $totalPricesIdr;
                $modelReservation->current_rate = $currency['kurs'];
                $modelReservation->id_status    = 1;//UNPAID
                $modelReservation->save(false);
                if ($modelReservation->pickup == true) {
                    $dataPickup = [
                        'id_booking' => $modelReservation->id,
                        'id_area' => $modelReservation->pickupArea,
                        'description' => $modelReservation->pickupDescription,
                        'type' => true,
                    ];
                    TShuttle::addShuttle($dataPickup);
                }
                if ($modelReservation->dropOff == true) {
                    $dataDrop = [
                        'id_booking' => $modelReservation->id,
                        'id_area' => $modelReservation->dropOffArea,
                        'description' => $modelReservation->dropOffDescription,
                        'type' => false,
                    ];

                    TShuttle::addShuttle($dataDrop);
                }
                $session['token']         = $modelReservation->id;
                $loadPassengers           = Yii::$app->request->post('TPassenger');
                foreach ($loadPassengers['adults'] as $key => $valueAdult) {
                    $adultData = [
                        'id_booking'     => $modelReservation->id,
                        'name'           => $valueAdult['name'],
                        'id_nationality' => $valueAdult['id_nationality'],
                        'birthday'       => NULL,
                        'type'           => TPassenger::TYPE_ADULT,
                    ];
                    TPassenger::addPassenger($adultData);  
                }

                if (isset($loadPassengers['childs'])) {
                    foreach ($loadPassengers['childs'] as $key => $valueChilds) {
                        $childData = [
                            'id_booking'     => $modelReservation->id,
                            'name'           => $valueChilds['name'],
                            'id_nationality' => $valueChilds['id_nationality'],
                            'birthday'       => NULL,
                            'type'           => TPassenger::TYPE_CHILD,
                        ];
                        TPassenger::addPassenger($childData);  
                    }
                }
                unset($session['reservation']);
                $transaction->commit();
                return $this->redirect(['confirm']);
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

        }
        $listShuttleArea = ArrayHelper::map(TShuttleArea::find()->asArray()->all(), 'id', 'area');
        return $this->render('fill-detail',[
            'listNationoality' => $listNationoality,
            'modelReservation'       => $modelReservation,
            'trip'             => $trip,
            'package'          => $package,
            'modelPasengers'   => $modelPasengers,
            'listShuttleArea'   => $listShuttleArea,
        ]);
    }

    public function actionEdit(){
        $session        = Yii::$app->session;
        $session->open();
        $model          = $this->getBooking($session['token']);
        $modelPasengers = $model->allPassengers;
        if (Yii::$app->request->isPost) {
            $buyer = Yii::$app->request->post('TBooking');
            $model->name  = $buyer['name'];
            $model->email = $buyer['email'];
            $model->phone = $buyer['phone'];
            if ($model->validate()) {
                $model->save(false);
                if(Model::loadMultiple($modelPasengers,Yii::$app->request->post()) && Model::validateMultiple($modelPasengers)){
                    foreach ($modelPasengers as $key => $value) {
                        $value->save(false);
                    }

                    Yii::$app->session->setFlash('success','Saved Data Successfully');
                }else{
                    Yii::$app->session->setFlash('danger','Saved Data Failed');
                }
            }else{
                Yii::$app->session->setFlash('danger','Saved Data Failed');
            }
        }
        $listNationoality = ArrayHelper::map(TNationality::getNationality(), 'id', 'nationality');
        $trip             = $this->findOneTrip($session['reservation']['id_trip']);
        $package          = [
            'adults' => $session['reservation']['adults'],
            'childs' => $session['reservation']['childs']
        ];
        return $this->render('fill-detail',[
            'listNationoality' => $listNationoality,
            'modelReservation'       => $model,
            'trip'             => $trip,
            'package'          => $package,
            'modelPasengers'   => $modelPasengers,
        ]);

    }
    
    public function actionChangeDate(){
        if (Yii::$app->request->isAjax && isset($_POST['date'])) {
            $session          = Yii::$app->session;
            $model            = $this->getBooking($session['token']);
            $model->trip_date = $_POST['date'];
            $model->save(false);
            return true;
        }else{
            return $this->goHome();
        }
    }

    public function actionConfirm(){
        $session          = Yii::$app->session;
        if (($booking = TBooking::findOne(['t_booking.id'=>$session['token']])) !== null) {
            return $this->render('confirm',['modelBooking'=>$booking]);
        }else{
            throw new NotFoundHttpException('Data Not Found');
        }

       
    }
    public function actionPayment(){
        $session          = Yii::$app->session;
        $model = $this->getBooking($session['token']);
        if (Yii::$app->request->isPost && isset($_POST['payment_method'])) {
            if ($_POST['payment_method'] == 1) {
                $model->id_payment_method = $_POST['payment_method'];
                $model->id_status = TBooking::STATUS_UNPAID;
                $model->save(false);
                Yii::$app->runAction('/reservation/generate-ticket');
                Yii::$app->session->setFlash('success', 'Reservation Succesfull. Please check your Email for the Confirmation Letter');
                return $this->goHome();
            }else{
                Yii::$app->session->setFlash('danger', 'Validation Failed, Please Try Again');
            }
        }
        $listPaymentMethod = TPaymentMethod::find()->orderBy(['id'=>SORT_DESC])->asArray()->all();
        return $this->render('payment',[
            'listPaymentMethod'=>$listPaymentMethod,
        ]);
    }

    public function actionRenderPaypalButton(){
         $session       = Yii::$app->session;
         $data = Yii::$app->request->post();
         if($paymentData = $this->getBookingAsArray($session['token'])){
            $message = 'Payment '.$paymentData['idTrip']['name'].' At '.date('D, d-M-Y',strtotime($paymentData['trip_date'])).' From ';
            $items[0] = [
                'name'=> $paymentData['idTrip']['name'].' At '.date('D, d-M-Y',strtotime($paymentData['trip_date'])).' ('.count($paymentData['allPassengers']).' Pax)',
                'price' => $paymentData['amount'],
                'quantity' => 1,
                'description' => $paymentData['token'],
                'currency'=> $paymentData['id_currency']
            ];
            // if (!empty($paymentData['shuttles'])) {
            //     foreach ($paymentData['shuttles'] as $key => $value) {
            //        // if ($value['price'] > 0) {
            //             $type = $value['type'] == true ? 'Pickup' : 'Drop Off';
            //             $price = round($value['price']/$paymentData['current_rate'],0,PHP_ROUND_HALF_UP);
            //             $items[] = [
            //                 'name' => $type.' at '.$value['idArea']['area'],
            //                 'quantity' => 1,
            //                 'price' => $price,
            //                 'currency'=> $paymentData['id_currency']
            //             ];
            //             $shuttlesPrice[] = $price;
            //        // }
            //     }
            //     $totalPrice = $items[0]['price']+array_sum($shuttlesPrice);
            // }else{
               // $totalPrice = $items[0]['price'];
            //}
            $paymentData = [
                'currency' => $paymentData['id_currency'],
                'total_price' => $paymentData['amount'],
                'items' => $items,
            ];
            return $this->renderAjax('paypal',[
                'modelPayment' => $paymentData,
                'message' => $message,
            ]); 
         }            
    }

    public function actionPaypalSuccess(){
        if (Yii::$app->request->isAjax) {
            $session       = Yii::$app->session;
            $data = $_POST['umk'];
            $arrayTransaction = $data['transactions'][0]['related_resources'][0]['sale'];
            $model = $this->getBooking($session['token']);
            if ($data['transactions'][0]['item_list']['items'][0]['description'] == $model->token && $arrayTransaction['amount']['total'] >= $model->amount) {
                $model->id_payment_method = 2; //paypal
                $model->id_status = TBooking::STATUS_PAID; //PAID
                $model->save(false);
                Yii::$app->runAction('/reservation/generate-ticket');
                $session                = session_unset();
                Yii::$app->session->setFlash('success', 'Reservation Succesfull. Please check your Email for the Confirmation Letter');
                return $this->goHome();//$this->redirect(['thank-you']);
            }
            $session = Yii::$app->session;
           
        }else{
            return $this->goHome();
        }
    }

    public function actionGenerateTicket($destination = Pdf::DEST_FILE){
        $session = Yii::$app->session;
        $modelBooking = $this->getBooking($session['token']);
        if($destination == Pdf::DEST_FILE){
            $savePath =  Yii::$app->basePath."/E-Ticket/".$modelBooking->token."/";
            FileHelper::createDirectory ( $savePath, $mode = 0777, $recursive = true );
            $filename = $savePath.'E-Voucher.pdf';
        }else{
            $filename = 'E-Voucher.pdf';
        }
        $Ticket = new Pdf([
            'filename'    => $filename,
            // A4 paper format
            'format'      => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // simpan file
            'destination' => $destination,
            'content' => "
                ".$this->renderPartial('/ticketing/ticket',[
                    'modelBooking'=>$modelBooking,
                    ])." ",
                    'cssInline' => '
                        @media print{
                            .page-break{display: block;page-break-before: always;}
                        }
                    ',
                    //set mPDF properties on the fly
                    'options'   => ['title' => 'E-Voucher Mountainerary'],
                    // call mPDF methods on the fly
                    'methods'   => [ 
                        'SetHeader' =>['E-Voucher Mountainerary'], 
                        'SetFooter' =>[
                            '<b>Please take this Ticket on your trip as a justification</b>'
                        ],
                    ]
        ]);
        $Ticket->render();
        Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['reservationEmail'])
                ->setTo($modelBooking->email)
                ->setBcc(Yii::$app->params['reservationEmail'])
                ->setSubject('Voucher Mountainerary')
                ->setHtmlBody(
                    $this->renderPartial('/ticketing/email-ticket',[
                    'modelBooking'=>$modelBooking,
                    ])
                )
                ->attach($savePath."E-Voucher.pdf")
                ->send();
        FileHelper::removeDirectory($savePath);

    }

    protected function getCurrency($currency){
        if (($currency = TCurrency::getCurrency($currency)) !== null) {
            return $currency;
        }else{
            throw new NotFoundHttpException('Currency Not Supported Please Try Another Currency');
        }
    }

    protected function getBookingAsArray($code_booking){
        if (($booking = TBooking::find()->joinWith(['idTrip','allPassengers','shuttles.idArea'])->where(['t_booking.id'=>$code_booking])->one()) !== null) {
            return $booking;
        }else{
            return false;
        }
    }

    protected function getBooking($code_booking){
        if (($booking = TBooking::find()->joinWith(['idTrip'])->where(['t_booking.id'=>$code_booking])->one()) !== null) {
            return $booking;
        }else{
            throw new NotFoundHttpException('Data Not Found/Your session timeout');
        }
    }
   protected function findOneTrip($id){
        if (($listProduct = TTrip::findOne($id)) !== null) {
            return $listProduct;
        }else{
            throw new NotFoundHttpException('Data Not Found');
        }
   }
}
