<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.04.30.
 * Time: 15:26
 */

namespace app\components;

use yii\helpers\Json;

class PaymentImport extends Component
{
    public static function processJson($json)
    {
        $arr=Json::decode($json);

        foreach ($arr as $item) {

        }
    }
}