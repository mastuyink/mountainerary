<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\TCategory */
/* @var $form yii\widgets\ActiveForm */
$this->params['breadcrumbs'][] = ['label' => 'List Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
<div class="well">
<h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
	    <div class="col-md-4">
	    	<?= $form->field($model, 'id_item_type')->dropDownList($listItemType, ['prompt' => 'Select...']); ?>
	    </div>
	    <div class="col-md-4">
	    	<?= $form->field($model, 'category')->textInput(['maxlength' => true,'id'=>'form-name']) ?>
		</div>
        <div class="col-md-4">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'id'=>'form-slug']) ?>
        </div>
	</div>
	<?= $form->field($model, 'keywords')->widget(Select2::classname(), [
        'data' => $listKeywords,
        'options' => ['placeholder' => 'Insert keyword ...', 'multiple' => true,'id'=>'form-keyword'],
        'pluginOptions' => [
            'tags' => true,
            'allowClear'=>true,
            'tokenSeparators' => [','],
            'maximumInputLength' => 100,
        ],
        ])->label('Keywords ( Separated with "," ) '); ?>
    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block btn-raised']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
<?php 
$this->registerJs("
$('#form-name').on('blur',function(){
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