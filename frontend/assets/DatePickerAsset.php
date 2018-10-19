<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class DatePickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/pickadate/lib';
    public $css = [
        'compressed/themes/default.css',
        'compressed/themes/default.date.css'
        
    ];
    public $js = [
       'compressed/picker.js',
       'compressed/picker.date.js'
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        
    ];

    public $publishOptions = [
        'only' => [
            'compressed/themes/default.css',
            'compressed/themes/default.date.css',
            'compressed/picker.js',
            'compressed/picker.date.js'
        ],
        'forceCopy' => true,
        
    ];
   
}
