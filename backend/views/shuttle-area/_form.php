<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model common\models\TShuttleArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tshuttle-area-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
    	<?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-md-6">
    	<?= $form->field($model, 'default_price')->widget(MaskedInput::className(), [
                'options' => [
                    'class' => 'form-masked form-control'
                ],
                'mask'               => ['99,999','999,999','9,999,999'],
                'clientOptions'      => [
                'removeMaskOnSubmit' => true,
                ]
            ]) ?>
    </div>
    <div class="form-group col-md-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-raised btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
