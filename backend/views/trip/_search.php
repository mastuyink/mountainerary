<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TripSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ttrip-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'id_category') ?>

    <?= $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'preview') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'price_min') ?>

    <?php // echo $form->field($model, 'price_pax') ?>

    <?php // echo $form->field($model, 'min_pax') ?>

    <?php // echo $form->field($model, 'thumbnail') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
