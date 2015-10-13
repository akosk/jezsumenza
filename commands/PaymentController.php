<?php


namespace app\commands;

use app\components\PaymentImport;
use Exception;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class PaymentController extends Controller
{

    public function actionLoad($path)
    {
        Yii::info("{$path} betöltése...", 'public');
        Yii::getLogger()->flush(false);
        try {
            $json = file_get_contents($path);
            $json=iconv('ISO-8859-2', 'UTF-8', $json);
            $result = PaymentImport::processJson($json);
        } catch (Exception $e) {
            $this->stdout("Hiba történt az importálás során.\n", Console::BG_RED);
            $this->stdout($e->getMessage() . "\n");
            Yii::info("Hiba történt az importálás során. ".$e->getMessage(), 'public');
            Yii::getLogger()->flush(false);
            return 1;
        }
        $this->stdout($result['imported'], Console::BG_GREEN | Console::BOLD);
        $this->stdout(" payment imported. \n", Console::BG_GREEN);
        return 0;
    }
}
