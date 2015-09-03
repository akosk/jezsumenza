<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.07.06.
 * Time: 15:43
 */

namespace app\assets;


use yii\web\AssetBundle;

class BaseAssetBundle  extends AssetBundle{

    const ver='15';

    public function init()
    {
        parent::init();
        foreach ($this->js as $key=>$item) {
            $this->js[$key]=$item.'?ver='.self::ver;
        }
        foreach ($this->css as $key=>$item) {
            $this->css[$key]=$item.'?ver='.self::ver;
        }
    }
}