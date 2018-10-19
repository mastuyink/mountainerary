<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TTrip */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ttrips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttrip-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            'id_category',
            'meta_description',
            'preview',
            'content:ntext',
            'price_min',
            'price_pax',
            'min_pax',
            'thumbnail',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
