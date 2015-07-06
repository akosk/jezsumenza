<?php
/**
 * Created: Ákos Kiszely
 * Date: 2014.11.11.
 * Time: 8:56
 */

namespace app\assets;

use yii\web\AssetBundle;

class FontawesomeAnimationAsset extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome-animation';
    public $css = ['dist/font-awesome-animation.css'];
    public $js = [];
    public $depends = ['app\assets\FontawesomeAsset'];

}