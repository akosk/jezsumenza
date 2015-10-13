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
        Yii::getLogger()->flush(true);
        try {
            $arr = Json::decode($json);
            Yii::getLogger()->flush(true);
            $result = [
                'imported' => 0,
                'error'    => 0
            ];

            foreach ($arr as $item) {
                $profile = Profile::find()->where('yami_id=:id', [':id' => $item['kartyaszam']])->one();
                if ($profile && strlen($profile->yami_id) > 0) {
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

                        $lunchDate = "{$payment->year}-{$payment->month}-{$day['day']}";

                        $lunchRight = LunchRight::find()->where('user_id=:user_id AND lunch_date=:lunchDate', [
                            ':user_id'   => $profile->user_id,
                            ':lunchDate' => $lunchDate,
                        ])->one();

                        if ($day['statusz'] == 'nem') {
                            if ($lunchRight) {
                                $lunchRight->delete();
                            }
                            continue;
                        }

                        if ($day['statusz'] != 'igen') {
                            continue;
                        }

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
                } else {
                    Yii::info("Befizetések importálása során nem található az alábbi tanuló:
                    {$item['nev']} (id:{$item['kartyaszam']}) ",
                        ArChangeLoggerBehavior::LOG_CATEGORY);
                    Yii::getLogger()->flush(true);
                }
            }

            Yii::info("Befizetések importálása kész. " . $result['imported'] . " befizetés betöltve.",
                ArChangeLoggerBehavior::LOG_CATEGORY);
            Yii::getLogger()->flush(true);
        } catch (Exception $e) {
            Yii::info("Befizetések importálása sikertelen. " . $result['imported'] . " befizetés betöltve.",
                ArChangeLoggerBehavior::LOG_CATEGORY);
            Yii::info("Hiba: " . $e->getMessage(),
                ArChangeLoggerBehavior::LOG_CATEGORY);
            Yii::getLogger()->flush(true);
            throw $e;
        }

        return $result;
    }
}