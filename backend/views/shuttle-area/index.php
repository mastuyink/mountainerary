<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TShuttleAreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tshuttle Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="well">

     <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus-square"></i>', ['create'], [
            'class'       => 'btn btn-warning btn-raised',
            'data-toggle' => 'tooltip',
            'title'       => 'Add Trip',
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'area',
            [
                'header'=> 'Default Price',
                'format'=> 'raw',
                'value' => function($model){
                    if ($model->default_price > 0) {
                        return 'Rp '.number_format($model->default_price);    
                    }else{
                        return "Free";
                    }
                    
                }
            ],

            [
                'header' => 'Action',
                'format' => 'raw',
                'value' => function($model){
                    $edit = Html::a('', ['update','id'=>$model->id], [
                        'class'       => 'btn btn-sm btn-primary btn-raised fa fa-pencil',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Update',
                        'id'          => 'btn-update-'.$model->id
                    ]);
                    $password = Html::a('', ['delete','id'=>$model->id], [
                        'class'       => 'btn btn-sm btn-danger btn-raised fa fa-trash',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Delete',
                        'id' => 'btn-delete-'.$model->id,
                        'data'        => [
                                'confirm' => 'Are You Sure To Delete '.$model->area.'?  This action cannot be undone',
                                'method'  => 'post',
                        ],
                    ]);
                    return $edit." ".$password;
                }
            ]
        ],
    ]); ?>
</div>
</div>
