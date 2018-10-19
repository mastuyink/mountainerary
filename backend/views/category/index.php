<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Category';
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
            'idItemType.type',
            'category',
            [
                'header' => 'Meta Desc',
                'format'=> 'raw',
                'value' => function($model){
                    return substr($model->meta_description, 0,50);
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
                                'confirm' => 'Are You Sure To Delete ? This action cannot be undone',
                                'method'  => 'post',
                        ],
                    ]);
                    return $edit." ".$password;
                }
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
</div>
