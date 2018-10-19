<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Booking';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbooking-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="well">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => 'Code',
                'attribute' => 'id',
                'contentOptions'=> ['style'=>'width: 50px;'],
            ],
            [
                'header' => 'Desc',
                'format' => 'raw',
                'value' => function($model){
                    $shuttle = null;
                    if (!empty($model->shuttles)) {
                        foreach ($model->shuttles as $key => $value) {
                            $type = $value->type == TRUE ? 'Pickup' : 'Drop Off';
                            $shuttle[] =  $type.' '.$value->idArea->area;
                        }
                        $shuttle = '<i class="fa fa-car"></i> '.join('<br><i class="fa fa-car"></i> ',$shuttle);
                    }
                    return '<i class="fa fa-user"></i> '.$model->name.' | '.$model->email.' | '.$model->phone.'<br><i class="fa fa-map-marker"></i> '.$model->idTrip->name.' <i class="fa fa-calendar"></i> <b> '.date('d-M-Y',strtotime($model->trip_date)).'</b><br>'.$shuttle;
                }
            ],
            [
                'header' => 'Pax',
                'format' => 'raw',
                'value' => function($model){
                    $adult = count($model->adultPassengers).' Adult';
                    $child = NULL;
                    $Cchild = count($model->childPassengers);
                    if ($Cchild > 0) {
                        $child = ' | '.$Cchild.' Child';
                    }
                    return '<b>'.count($model->allPassengers).' Pax </b><br>'.$adult.$child;
                }
            ],
            [
                'header' => 'Payment',
                'format' => 'raw',
                'value' => function($model){
                    if ($model->id_payment_method == $model::PAYMENT_PAYPAL) {
                        $method = '<i class="fa fa-paypal"></i> Paypal/Credit Card ';
                    }elseif ($model->id_payment_method == $model::PAYMENT_POD) {
                        $method = '<i class="fa fa-money"></i> Pay on Departure ';
                    }
                    $total_idr = 'IDR '.number_format($model->amount_idr,0);
                    $payment = '<b>'.$model->id_currency.' '.number_format($model->amount,2).'<br>'.$total_idr.'</b><br> Rate 1 '.$model->id_currency.' = IDR '.number_format($model->current_rate,0);
                    return $method.$payment;
                }
            ],
            [
                'header' => 'Detail',
                'format' => 'raw',
                'value' => function($model){
                    $button = Html::button('<i class="glyphicon glyphicon-modal-window"></i>', [
                        'class' => 'btn btn-raised btn-xs btn-warning btn-detail',
                        'id-booking' => $model->id,
                    ]);
                    return $button;
                }
            ]
        ],
    ]); ?>
</div>
<?php 

$this->registerJs('
$(".btn-detail").on("click",function(){
    $("#modal-detail").modal({
        keyboard: true
    });
    var idBooking = $(this).attr("id-booking");
    $.ajax({
        url: "/booking/detail?id_booking="+idBooking,
        type: "GET",
        success: function(data){
            $("#modal-body").html(data);
        },
        error: function(data){
            $("#modal-body").html(data);
        }
    });
});
', \yii\web\View::POS_READY);
?>
<div id="modal-detail" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Passengers Detail</h4>
      </div>
      <div class="modal-body">
        <div class="row" id="modal-body">
            <center><p>Please Wait....</p><i class="fa fa-spin fa-refresh"></i></center>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 63.5px; top: 7.28333px; background-color: rgb(0, 150, 136); transform: scale(11.125);"></div></div></button>
      </div>
    </div>
  </div>
</div>
    <?php Pjax::end(); ?>
</div>
