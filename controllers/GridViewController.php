<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.07.16.
 * Time: 10:54
 */

namespace app\controllers;

use Yii;

class GridViewController extends ControllerBase
{
    const DEFAULT_PAGESIZE = 20;
    const PREFIX = "GRIDVIEW_PAGESIZE_";

    public function actionSetPageSize($class, $pagesize)
    {
        Yii::$app->session->set($this->getId($class), $pagesize);
    }

    private static function getId($class)
    {
        return self::PREFIX . str_replace("\\",'',$class);
    }

    public static function getPageSize($class)
    {
        $pageSize = Yii::$app->session->get(self::getId($class));
        return $pageSize == 0 ? self::DEFAULT_PAGESIZE : $pageSize;
    }
}