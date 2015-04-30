<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.04.30.
 * Time: 15:26
 */

namespace app\components;

use app\models\LunchRight;
use app\models\Payment;
use app\models\Profile;
use yii\helpers\Json;

class PaymentImport extends Component
{
    public static function processJson($json)
    {
        $arr = Json::decode($json);

        foreach ($arr as $item) {
            $profile = Profile::find('dina_id=:id')->where([':id' => $item['tanulo_dina_azonosíto']])->one();
            if ($profile && strlen($profile->dina_id) > 0) {
                $payment = new Payment();
                $payment->user_id = $profile->user_id;
                $payment->year = $item['ev'];
                $payment->month = $item['honap'];
                $payment->amount = $item['befizetes'];
                $payment->save();

                foreach ($item['jogosult_napok'] as $day) {
                    if ($day['status'] != 'igen') {
                        continue;
                    }
                    $lunchRight = new LunchRight();

                    $lunchRight->user_id = $profile->user_id;
                    $lunchRight->lunch_date = "{$payment->year}-{$payment->month}-{$day['day']}";
                    $lunchRight->status = LunchRight::STATUS_FULL;
                    $lunchRight->save();
                }
            }
        }
    }
}