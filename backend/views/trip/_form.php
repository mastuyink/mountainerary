<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\TTrip */
/* @var $form yii\widgets\ActiveForm */
$listTime = ['00:00:00'=>'00:00', '00:15:00'=>'00:15', '00:30:00'=>'00:30', '00:45:00'=>'00:45', '01:00:00'=>'01:00', '01:15:00'=>'01:15', '01:30:00'=>'01:30', '01:45:00'=>'01:45', '02:00:00'=>'02:00', '02:15:00'=>'02:15', '02:30:00'=>'02:30', '02:45:00'=>'02:45', '03:00:00'=>'03:00', '03:15:00'=>'03:15', '03:30:00'=>'03:30', '03:45:00'=>'03:45', '04:00:00'=>'04:00', '04:15:00'=>'04:15', '04:30:00'=>'04:30', '04:45:00'=>'04:45', '05:00:00'=>'05:00', '05:15:00'=>'05:15', '05:30:00'=>'05:30', '05:45:00'=>'05:45', '06:00:00'=>'06:00', '06:15:00'=>'06:15', '06:30:00'=>'06:30', '06:45:00'=>'06:45', '07:00:00'=>'07:00', '07:15:00'=>'07:15', '07:30:00'=>'07:30', '07:45:00'=>'07:45', '08:00:00'=>'08:00', '08:15:00'=>'08:15', '08:30:00'=>'08:30', '08:45:00'=>'08:45', '09:00:00'=>'09:00', '09:15:00'=>'09:15', '09:30:00'=>'09:30', '09:45:00'=>'09:45', '10:00:00'=>'10:00', '10:15:00'=>'10:15', '10:30:00'=>'10:30', '10:45:00'=>'10:45', '11:00:00'=>'11:00', '11:15:00'=>'11:15', '11:30:00'=>'11:30', '11:45:00'=>'11:45', '12:00:00'=>'12:00', '12:15:00'=>'12:15', '12:30:00'=>'12:30', '12:45:00'=>'12:45', '13:00:00'=>'13:00', '13:15:00'=>'13:15', '13:30:00'=>'13:30', '13:45:00'=>'13:45', '14:00:00'=>'14:00', '14:15:00'=>'14:15', '14:30:00'=>'14:30', '14:45:00'=>'14:45', '15:00:00'=>'15:00', '15:15:00'=>'15:15', '15:30:00'=>'15:30', '15:45:00'=>'15:45', '16:00:00'=>'16:00', '16:15:00'=>'16:15', '16:30:00'=>'16:30', '16:45:00'=>'16:45', '17:00:00'=>'17:00', '17:15:00'=>'17:15', '17:30:00'=>'17:30', '17:45:00'=>'17:45', '18:00:00'=>'18:00', '18:15:00'=>'18:15', '18:30:00'=>'18:30', '18:45:00'=>'18:45', '19:00:00'=>'19:00', '19:15:00'=>'19:15', '19:30:00'=>'19:30', '19:45:00'=>'19:45', '20:00:00'=>'20:00', '20:15:00'=>'20:15', '20:30:00'=>'20:30', '20:45:00'=>'20:45', '21:00:00'=>'21:00', '21:15:00'=>'21:15', '21:30:00'=>'21:30', '21:45:00'=>'21:45', '22:00:00'=>'22:00', '22:15:00'=>'22:15', '22:30:00'=>'22:30', '22:45:00'=>'22:45', '23:00:00'=>'23:00', '23:15:00'=>'23:15', '23:30:00'=>'23:30', '23:45:00'=>'23:45',]
?>

<div class="ttrip-form">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'id'=>'form-name']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'id'=>'form-slug']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'id_category')->dropDownList($listCategory, [
                'id' => 'drop-category',
                'prompt' => 'Select...',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'price_min')->widget(MaskedInput::className(), [
                'options' => [
                    'class' => 'form-masked form-control'
                ],
                'mask'               => ['99,999','999,999','9,999,999'],
                'clientOptions'      => [
                'removeMaskOnSubmit' => true,
                ]
            ]) ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'min_pax')->widget(MaskedInput::className(), [
                'options' => [
                    'class' => 'form-masked form-control'
                ],
                'mask'               => ['9'],
                'clientOptions'      => [
                'removeMaskOnSubmit' => true,
                ]
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'price_pax_adult')->widget(MaskedInput::className(), [
                'options' => [
                    'class' => 'form-masked form-control'
                ],
                'mask'               => ['99,999','999,999','9,999,999'],
                'clientOptions'      => [
                'removeMaskOnSubmit' => true,
                ]
            ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'price_pax_child')->widget(MaskedInput::className(), [
                'options' => [
                    'class' => 'form-masked form-control'
                ],
                'mask'               => ['99,999','999,999','9,999,999'],
                'clientOptions'      => [
                'removeMaskOnSubmit' => true,
                ]
            ]) ?>
        </div>
        <div class="col-md-3">
            <br><br>
            <div class="togglebutton">
                <label>
                <?= Html::activeCheckbox($model, 'status', [
                    //'id' => 'checkbox-status',
                    'label' => false,
                    'checked'=> true
                ]); ?>
                Status 
                </label>
            </div>
        </div>
    </div>

    <?php 
    if (!$model->isNewRecord) {
        echo "<h1>UPDATED</h1>";
        $preview = [
            'initialPreview' =>[
               '/trip/thumbnail?id='.$model->id,
            ],
            'initialPreviewAsData'=>true,
            'initialCaption'=>'Thumbnail',
        ];
    }else{
        $preview = null;
    }
    ?>
    <?= $form->field($model, 'thumbnailFile')->widget(FileInput::classname(), [
        'options' => [
        'multiple'=>false,
        'accept' => 'image/*',
        'resizeImages'=>true,
        ],
        'pluginOptions' => [
            'initialPreview' =>[
               '/trip/thumbnail?id='.$model->id,
            ],
            'initialPreviewAsData'=>true,
            'initialCaption'=>'Thumbnail',
            'showCaption' => false,
            'showRemove' => true,
            'showUpload' => false,
            'browseClass' => 'btn btn-warning btn-block btn-raised',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Thumbnail'
        ],
    ])->label(false); ?>
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


    <div class="panel panel-info">
        <div class="panel-heading">Create Your Itinerary <?= Html::a('', null, ['id'=>'btn-add-form','class' => 'btn btn-sm fa fa-plus btn-success btn-raised']); ?></div>
        <div class="body">
            <div class="row" id="row-timeline">
                <?php if(!$modelTimelines[0]->isNewRecord && $modelTimelines[0]->id_trip != NULL): ?>
                <?php foreach ($modelTimelines as $key => $modelTimeline): ?>
                    <div id="div-<?= $key ?>" class="col-md-12">
                        <?= Html::activeHiddenInput($modelTimeline, "[$key]id"); ?>
                        <div class="col-md-5">
                            <?= $form->field($modelTimeline, "[$key]name")->textInput([
                                'class' => 'form-control form-timeline-name',
                                'id' => 'form-timeline-name-0'
                            ]); ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($modelTimeline, "[$key]duration")->dropDownList(['0'=>'Same Day','1'=>'Day 1','2'=>'Day 2','3'=>'Day 3','4'=>'Day 4','5'=>'Day 5','6'=>'Day 6'],[
                                'class'=>'form-control form-timeline-duration',
                                'id' => 'form-timeline-duration-0'
                            ]); ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($modelTimeline, "[$key]time_start")->dropDownList($listTime, [
                                'class' => 'form-control form-timeline-start',
                                'id' => 'form-timeline-start-0'
                            ]); ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($modelTimeline, "[$key]time_end")->dropDownList($listTime, [
                                'class' => 'form-control form-timeline-end',
                                'id' => 'form-timeline-end-0'
                            ]); ?>
                        </div>
                        <?= Html::a('', null, ['id'=>'btn-delete',
                            'class'   => 'btn btn-sm fa fa-minus btn-danger btn-raised btn-remove-timeline',
                            'div-target' => $key
                        ]); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
<?php Pjax::begin(['id'=>'pjax-service']) ?>
    <div class="row">
        <div class="panel panel-info">
        <div class="panel-heading">Trip Service</div>
        <div class="body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <div class="form-line">
                            <?= Html::textInput('service', null, [
                                'id'    =>'form-new-service',
                                'class' => 'form-control',
                                'placeholder' => 'Add New Service',
                            ]); ?>
                            </div>
                            <span class="input-group-addon">
                                <?= Html::button('', [
                                    'class' => 'btn btn-md btn-raised btn-warning fa fa-save',
                                    'onclick' => '
                                        var vservice = $("#form-new-service").val();
                                        if (vservice != "") {
                                            $.ajax({
                                                url: "'.Url::to(['/trip/add-service']).'",
                                                method:"POST",
                                                data: {
                                                    service : vservice
                                                },
                                                success : function(data){
                                                    $("#form-new-service").val("");
                                                    var service = JSON.parse(data);
                                                    var newInclude = \'<div class="col-sm-4"><div class="checkbox"><label><input name="TTrip[includes][]" value=\'+ service.value +\' type="checkbox"><span class="checkbox-material"><span class="check"></span></span> \'+ service.service +\'</label></div></div>\';
                                                    var newExclude = \'<div class="col-sm-4"><div class="checkbox"><label><input name="TTrip[excludes][]" value=\'+ service.value +\' type="checkbox"><span class="checkbox-material"><span class="check"></span></span> \'+ service.service +\'</label></div></div>\';
                                                    $("#form-list-include").append(newInclude);
                                                    $("#form-list-exclude").append(newExclude);
                                                },
                                                error:function(){
                                                    alert("add Service Failed");
                                                }
                                            });
                                        }' 
                                ]); ?>
                            </span>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                        <center><h4>Include</h4></center>
                            <?= $form->field($model, 'includes')->checkboxList($listService, [
                                'id' => 'form-list-include',
                                'item' => function($index, $label, $name, $checked, $value) {
                                      $checked = $checked ? 'checked' : '';
                                      $return = "<div class='col-sm-4'><div class='checkbox'><label><input type='checkbox' name='{$name}' value='{$value}' {$checked}> {$label} </label></div></div>";
                                      return $return;
                                   },
                        ])->label(false); ?>
            </div>
            <div class="col-md-6">
                <center><h4>Exclude</h4></center>
                    <?= $form->field($model, 'excludes')->checkboxList($listService, [
                        'id' => 'form-list-exclude',
                        'item' => function($index, $label, $name, $checked, $value) {
                            $checked = $checked ? 'checked' : '';
                            $return = "<div class='col-sm-4'><div class='checkbox'><label><input type='checkbox' name='{$name}' value='{$value}' {$checked}> {$label}";
                            $return .= "</label></div></div>";
                            return $return;
                        },
                    ])->label(false); ?>
            </div>
        </div>
        </div>
    </div>
    </div>
<?php Pjax::end(); ?>
        <?= $form->field($model, 'content')->textarea([
            'rows' => 6,
            'id' => 'content-area'
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-lg btn-raised btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
app\assets\CkEditorAsset::register($this);
// $this->registerJsFile(
//     'href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"',
//     ['depends' => [\yii\web\JqueryAsset::className()]]
// );
// $this->registerCssFile(
//     'src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"',
//     ['depends' => [\yii\web\JqueryAsset::className()]]
// );
$this->registerJs("
$('#btn-add-form').on('click',function(){
    var numberOrder = $('.form-timeline-name').size();
    $('#row-timeline').append('<div id=\"div-'+ numberOrder +'\" class=\"col-md-12\"><div class=\"col-md-5\"><div class=\"form-group field-form-timeline-name-'+ numberOrder +' required is-empty\"><label class=\"control-label\" for=\"form-timeline-name-'+ numberOrder +'\">Name</label><input id=\"form-timeline-name-'+ numberOrder +'\" class=\"form-control form-timeline-name\" name=\"TTripTimeline['+ numberOrder +'][name]\" type=\"text\"><div class=\"help-block\"></div></div></div><div class=\"col-md-2\"><div class=\"form-group field-form-timeline-duration-'+ numberOrder +' required\"><label class=\"control-label\" for=\"form-timeline-duration-'+ numberOrder +'\">Duration</label><select id=\"form-timeline-duration-'+ numberOrder +'\" class=\"form-control form-timeline-duration\" name=\"TTripTimeline['+ numberOrder +'][duration]\"><option value=\"0\">Same Day</option><option value=\"1\">Day 1</option><option value=\"2\">Day 2</option><option value=\"3\">Day 3</option><option value=\"4\">Day 4</option><option value=\"5\">Day 5</option><option value=\"6\">Day 6</option></select><div class=\"help-block\"></div></div></div><div class=\"col-md-2\"><div class=\"form-group field-form-timeline-start-'+ numberOrder +' required\"><label class=\"control-label\" for=\"form-timeline-start-'+ numberOrder +'\">Time Start</label><select id=\"form-timeline-start-'+ numberOrder +'\" class=\"form-control form-timeline-start\" name=\"TTripTimeline['+ numberOrder +'][time_start]\">'+ getTimeList() +'</select><div class=\"help-block\"></div></div></div><div class=\"col-md-2\"><div class=\"form-group field-form-timeline-end-'+ numberOrder +' required\"><label class=\"control-label\" for=\"form-timeline-end-'+ numberOrder +'\">Time End</label><select id=\"form-timeline-end-'+ numberOrder +'\" class=\"form-control form-timeline-end\" name=\"TTripTimeline['+ numberOrder +'][time_end]\">'+ getTimeList() +'</select><div class=\"help-block\"></div></div></div></div>');
});

$('.btn-remove-timeline').on('click',function(){
    $('#div-'+$(this).attr('div-target')).remove();
});

CKEDITOR.replace( 'TTrip[content]' );

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

function getTimeList(){
    return '<option value=\"00:00\">00:00</option><option value=\"00:15\">00:15</option><option value=\"00:30\">00:30</option><option value=\"00:45\">00:45</option><option value=\"01:00\">01:00</option><option value=\"01:15\">01:15</option><option value=\"01:30\">01:30</option><option value=\"01:45\">01:45</option><option value=\"02:00\">02:00</option><option value=\"02:15\">02:15</option><option value=\"02:30\">02:30</option><option value=\"02:45\">02:45</option><option value=\"03:00\">03:00</option><option value=\"03:15\">03:15</option><option value=\"03:30\">03:30</option><option value=\"03:45\">03:45</option><option value=\"04:00\">04:00</option><option value=\"04:15\">04:15</option><option value=\"04:30\">04:30</option><option value=\"04:45\">04:45</option><option value=\"05:00\">05:00</option><option value=\"05:15\">05:15</option><option value=\"05:30\">05:30</option><option value=\"05:45\">05:45</option><option value=\"06:00\">06:00</option><option value=\"06:15\">06:15</option><option value=\"06:30\">06:30</option><option value=\"06:45\">06:45</option><option value=\"07:00\">07:00</option><option value=\"07:15\">07:15</option><option value=\"07:30\">07:30</option><option value=\"07:45\">07:45</option><option value=\"08:00\">08:00</option><option value=\"08:15\">08:15</option><option value=\"08:30\">08:30</option><option value=\"08:45\">08:45</option><option value=\"09:00\">09:00</option><option value=\"09:15\">09:15</option><option value=\"09:30\">09:30</option><option value=\"09:45\">09:45</option><option value=\"10:00\">10:00</option><option value=\"10:15\">10:15</option><option value=\"10:30\">10:30</option><option value=\"10:45\">10:45</option><option value=\"11:00\">11:00</option><option value=\"11:15\">11:15</option><option value=\"11:30\">11:30</option><option value=\"11:45\">11:45</option><option value=\"12:00\">12:00</option><option value=\"12:15\">12:15</option><option value=\"12:30\">12:30</option><option value=\"12:45\">12:45</option><option value=\"13:00\">13:00</option><option value=\"13:15\">13:15</option><option value=\"13:30\">13:30</option><option value=\"13:45\">13:45</option><option value=\"14:00\">14:00</option><option value=\"14:15\">14:15</option><option value=\"14:30\">14:30</option><option value=\"14:45\">14:45</option><option value=\"15:00\">15:00</option><option value=\"15:15\">15:15</option><option value=\"15:30\">15:30</option><option value=\"15:45\">15:45</option><option value=\"16:00\">16:00</option><option value=\"16:15\">16:15</option><option value=\"16:30\">16:30</option><option value=\"16:45\">16:45</option><option value=\"17:00\">17:00</option><option value=\"17:15\">17:15</option><option value=\"17:30\">17:30</option><option value=\"17:45\">17:45</option><option value=\"18:00\">18:00</option><option value=\"18:15\">18:15</option><option value=\"18:30\">18:30</option><option value=\"18:45\">18:45</option><option value=\"19:00\">19:00</option><option value=\"19:15\">19:15</option><option value=\"19:30\">19:30</option><option value=\"19:45\">19:45</option><option value=\"20:00\">20:00</option><option value=\"20:15\">20:15</option><option value=\"20:30\">20:30</option><option value=\"20:45\">20:45</option><option value=\"21:00\">21:00</option><option value=\"21:15\">21:15</option><option value=\"21:30\">21:30</option><option value=\"21:45\">21:45</option><option value=\"22:00\">22:00</option><option value=\"22:15\">22:15</option><option value=\"22:30\">22:30</option><option value=\"22:45\">22:45</option><option value=\"23:00\">23:00</option><option value=\"23:15\">23:15</option><option value=\"23:30\">23:30</option><option value=\"23:45\">23:45</option>'
}
    ", \yii\web\View::POS_READY);
//<a class=\"btn btn-sm fa fa-minus btn-danger btn-raised btn-remove-timeline\" div-target=\"'+ numberOrder +'\"></a>
 ?>