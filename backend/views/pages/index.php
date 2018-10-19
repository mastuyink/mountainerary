<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('', ['create'], ['class' => 'btn btn-success btn-raised fa fa-plus-square']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'slug',
            [
                'format'=> 'raw',
                'value' => function($model){
                    return substr($model->meta_description, 0,50).'...';
                }
            ],
            'datetime',

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
                    return $edit;
                }
            ]
        ],
    ]); ?>
</div>
