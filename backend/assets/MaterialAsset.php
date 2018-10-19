<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class MaterialAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-material-design/dist';
    public $css = [
        'https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        'css/bootstrap-material-design.css',
        'css/ripples.css',
        
    ];
    public $js = [
        'js/material.js',
        'js/ripples.js'
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        
    ];

    public $publishOptions = [
        'only' => [
            'css/bootstrap-material-design.css',
            'css/ripples.css',
            'js/material.js',
            'js/ripples.js'
        ],
        'forceCopy' => true,
        
    ];
   
}
