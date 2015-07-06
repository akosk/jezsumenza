<?php
/**
 * Created: Ákos Kiszely
 * Date: 2014.11.10.
 * Time: 14:03
 */

namespace app\assets;

use yii\web\AssetBundle;

class GateAsset extends BaseAssetBundle
{
    public $basePath = '/';
    public $css = [];
    public $js = [
        'js/gate.module.js',
        'js/gate.config.js',
        'js/gateoneController.js',
        'js/factories/dataService.js',
//        'js/factories/helpers.js',
//        'js/filters/justDay.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\FontawesomeAnimationAsset',
        'app\assets\AngularAsset',
        'app\assets\UnderscoreAsset',
        'app\assets\AngularNgRouteAsset'
    ];


}