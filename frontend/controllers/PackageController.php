<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\TTrip;
use common\models\TGalery;
use common\models\TCurrency;
use app\models\BookingForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
/**
 * Site controller
 */
class PackageController extends Controller
{
    public $defaultAction = 'all-package';

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionAllPackage(){

        $query = TTrip::find()->joinWith(['idCategory'])->where(['status'=>TTrip::STATUS_ON]);
        $count = $query->count();
        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->pageSize = 6;

        // limit the query using the pagination and retrieve the articles
        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $session = Yii::$app->session;
        if ($session['currency'] == NULL) {
            $currentCurrency = 'USD';
        }else{
            $currentCurrency = $session['currency'];
        }
        $currency = TCurrency::find()->where(['currency'=>$currentCurrency])->asArray()->one();
        return $this->render('all-package',[
            'listProduct'=>$list,
            'pagination' => $pagination,
            'currency' => $currency,
        ]);
    }
    public function actionCategory($category,$slug = null)
    {
        $session = Yii::$app->session;
        if ($session['currency'] == NULL) {
            $currentCurrency = 'USD';
        }else{
            $currentCurrency = $session['currency'];
        }
        $currency = TCurrency::find()->where(['currency'=>$currentCurrency])->asArray()->one();
        if ($slug != null) {
            if (($product = TTrip::find()->joinWith(['idCategory','galerys','usedKeywords.idKeyword'])->where(['t_category.slug'=>$category])->andWhere(['t_trip.slug'=>$slug])->asArray()->one()) !== null) {
                $modelBookingForm = new BookingForm(); 
                if ($modelBookingForm->load(Yii::$app->request->post())) {
                    if ($modelBookingForm->validate()) {
                        $session = Yii::$app->session;
                        $session['reservation'] = [
                            'id_trip'   => $product['id'],
                            'trip_date' => $modelBookingForm->trip_date,
                            'adults'    => $modelBookingForm->adults,
                            'childs'    => $modelBookingForm->childs
                        ];
                        return $this->redirect(['/reservation/fill-detail']);
                    }else{
                        Yii::$app->session->setFlash('danger', 'Unable to validate Your Input');
                    }
                }
                return $this->render('view',[
                    'product'          => $product,
                    'modelBookingForm' => $modelBookingForm,
                    'currency'         => $currency,
                ]);
            }
        }else{
            $listProduct = TTrip::find()->joinWith(['idCategory','usedKeywords.idKeyword'])->where(['t_category.slug'=>$category])->asArray()->all();
            if (!empty($listProduct)) {
                return $this->render('index',[
                    'listProduct'=>$listProduct,
                    'currency'         => $currency,
                ]);
            }
        }
        throw new NotFoundHttpException('Data Not Found Please check your URl or you can contact us for advance support');
    }

   protected function findOneModel($slug){
        if (($listProduct = TTrip::find()->where(['slug'=>$slug])->asArray()->one()) !== null) {
            return $listProduct;
        }else{
            throw new NotFoundHttpException('Data Not Found');
        }
   }
}
