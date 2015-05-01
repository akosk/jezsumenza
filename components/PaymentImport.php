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
use Exception;
use tests\codeception\unit\components\ArChangeLoggerBehaviorTest;
use Yii;
use yii\base\Component;
use yii\db\Expression;
use yii\helpers\Json;

class PaymentImport extends Component
{
    public static function processJson($json)
    {
        Yii::info("Befizetések importálásnak megkezdése.", ArChangeLoggerBehavior::LOG_CATEGORY);

        try {
            $arr = Json::decode($json);

            $result = [
                'imported' => 0,
                'error'    => 0
            ];

            foreach ($arr as $item) {
                $profile = Profile::find()->where('dina_id=:id', [':id' => $item['tanulo_dina_azonosito']])->one();
                if ($profile && strlen($profile->dina_id) > 0) {
                    $payment = Payment::find()->where('user_id=:user_id AND year=:year AND month=:month', [
                        ':user_id' => $profile->user_id,
                        ':year'    => $item['ev'],
                        ':month'   => $item['honap'],
                    ])->one();
                    if (!$payment) {
                        $payment = new Payment();
                    }
                    $payment->user_id = $profile->user_id;
                    $payment->year = $item['ev'];
                    $payment->month = $item['honap'];
                    $payment->amount = $item['befizetes'];
                    $payment->create_time = new Expression('NOW()');
                    if ($payment->save()) {
                        $result['imported']++;
                    } else {
                        throw new Exception('A fizetés mentése nem sikerült.');
                    }

                    foreach ($item['jogosult_napok'] as $day) {
                        if ($day['status'] != 'igen') {
                            continue;
                        }

                        $lunchDate = "{$payment->year}-{$payment->month}-{$day['day']}";

                        $lunchRight = LunchRight::find()->where('user_id=:user_id AND lunch_date=:lunchDate', [
                            ':user_id' => $profile->user_id,
                            ':lunchDate'    => $lunchDate,
                        ])->one();
                        if (!$lunchRight) {
                            $lunchRight = new LunchRight();
                        }

                        $lunchRight->user_id = $profile->user_id;

                        $lunchRight->lunch_date = $lunchDate;
                        $lunchRight->status = LunchRight::STATUS_FULL;
                        $lunchRight->create_time = new Expression('NOW()');
                        if (!$lunchRight->save()) {
                            $errors = $lunchRight->getFirstErrors();
                            throw new Exception('Az ebédhez való jogosultság mentése nem sikerült. ' . implode(',', $errors));
                        }
                    }
                }
            }

            Yii::info("Befizetések importálása kész. " . $result['imported'] . " befizetés betöltve.",
                ArChangeLoggerBehavior::LOG_CATEGORY);
        } catch (Exception $e) {
            Yii::info("Befizetések importálása sikertelen. " . $result['imported'] . " befizetés betöltve.",
                ArChangeLoggerBehavior::LOG_CATEGORY);
            throw $e;
        }

        return $result;
    }
}