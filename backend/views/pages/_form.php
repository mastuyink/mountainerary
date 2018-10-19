<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\TPages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpages-form">

    <?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-md-6">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'id'=>'form-title']) ?>
  </div>
  <div class="col-md-6">
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'id'=>'form-slug']) ?>
  </div>
</div>
    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->widget(Select2::classname(), [
        'data' => $model->getKeywords(),
        'options' => ['placeholder' => 'Insert keyword ...', 'multiple' => true,'id'=>'form-keyword'],
        'pluginOptions' => [
            'tags' => true,
            'allowClear'=>true,
            'tokenSeparators' => [','],
            'maximumInputLength' => 100,
        ],
        ])->label('Keywords ( Separated with "," ) '); ?>

    <?= $form->field($model, 'content')->textarea([
      'rows' => 6,
      'id'   => 'content-area'
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-raised btn-warning btn-block btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
app\assets\CkEditorAsset::register($this);

$this->registerJs("
CKEDITOR.replace( 'TPages[content]' );
$('#form-title').on('blur',function(){
 var slug = convertToSlug($(this).val());
 $('#form-slug').val(slug);
});

function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-')
        ;
}
  ", \yii\web\View::POS_READY);
 ?>