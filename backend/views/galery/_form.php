<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
?>
<div class="row">
<div class="well">
<?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data']
    ]); ?>
<?= $form->field($modelGalery, 'galeryFiles[]')->widget(FileInput::classname(), [
        'options' => [
            'multiple'=>true,
            'accept' => 'image/*',
            'resizeImages'=>true,
            ],
            'pluginOptions' => [
                'initialPreview'       => $galeryPreview['preview'],
                'initialPreviewAsData' => true,
                'initialCaption'       => "Galery Image",
                'uploadUrl'            => Url::to(['/galery/upload']),
                'browseOnZoneClick'    => true,
                'showCaption'          => true,
                'showCaption'          => true,
                'showRemove'           => true,
               // 'showUpload' => false,
                'maxFileCount'         => 50,
                'uploadExtraData'      => $uploadExtraData,
                'initialPreviewConfig' => $galeryPreview['config'],
                ],

                'pluginEvents'=>[
                    'filebatchselected'=>'function(event, files) {
                                            $(this).fileinput("upload");
                                        }',
                    'filepreremove'=>'function(event, id, index) {
                                           alert(id)
                                        }'
                ]
    ])->label(false); ?>
<div class="form-group">
        <?= Html::submitButton(Yii::t('app', ' Save'), ['class' => 'btn btn-success fa fa-save btn-raised btn-lg']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>
</div>