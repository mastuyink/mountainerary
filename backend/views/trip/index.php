<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trip List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="well">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            
            [
                'header' => 'Name Of Trip',
                'format' => 'raw',
                'value' => function($model){
                    return "<span style='font-size: 12px'>".$model->idCategory->category.'</span><br>'.$model->name;
                }
            ],
            [
                'header' => 'Content Items',
                'format' => 'raw',
                'value' => function($model){
                    return "<span style='font-size: 12px'>".count($model->galerys).' Galery</span>';
                }
            ],
           // 'meta_description',
            [
                'header' => 'Pricing',
                'format' => 'raw',
                'value' => function($model){
                    return 'Min = Rp '.number_format($model->price_min,0).' / '.$model->min_pax."<br> Extra A @ Rp ".number_format($model->price_pax_adult,0)." | C @ Rp ".number_format($model->price_pax_child,0);
                }
            ],
            // [
            //     'header' => 'Status',
            //     'format' => 'raw',
            //     'value' => function($model){

            //         $switch =  Html::beginForm(['update', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data','id'=>'form-'.$model->id]).'<div class="togglebutton">
            //                     <label>'.Html::checkbox('TTrip[status]', [
            //                         'id' => 'checkbox-status-'.$model->id,
            //                         //'checked'=> false,
            //                         'onclick'=>'alert("OK");'
            //                     ]).'
            //                     </label>
            //                 </div>'.Html::endForm();
            //     return $switch;
            //     }
            // ],
            [
                'header' => 'Action',
                'format' => 'raw',
                'value' => function($model){
                    //item trype = 1 (Trip item type)
                    $addGalery = Html::a('', ['/galery/add','modelParent'=>'TTrip','id_parent'=>$model->id,'itemType'=>1,'returnUrl'=>'/trip/index'], [
                        'class'       => 'btn btn-sm btn-success btn-raised fa fa-file-image-o',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Galery',
                        'id'          => 'btn-galery-'.$model->id
                    ]);
                    $edit = Html::a('', ['update','id'=>$model->id], [
                        'class'       => 'btn btn-sm btn-primary btn-raised fa fa-pencil',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Update',
                        'id'          => 'btn-update-'.$model->id
                    ]);
                    $delete = Html::a('', ['delete','id'=>$model->id], [
                        'class'       => 'btn btn-sm btn-danger btn-raised fa fa-trash',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Delete',
                        'id' => 'btn-delete-'.$model->id,
                        'data'        => [
                                'confirm' => 'Are You Sure To Delete trip '.$model->name.'?  This action cannot be undone',
                                'method'  => 'post',
                        ],
                    ]);
                    $following = Html::a('', ['follow-up','id_trip'=>$model->id], [
                        'class'       => 'btn btn-sm btn-danger btn-raised fa fa-arrow-up',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Follow Up',
                        'id' => 'btn-follow-up-'.$model->id,
                        'data'        => [
                                'confirm' => 'Are You Sure to FOllow Up trip '.$model->name.'?',
                                'method'  => 'post',
                        ],
                    ]);
                    return $following." ".$addGalery." ".$edit." ".$delete;
                }
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
