<?php


namespace app\commands;

use app\components\PaymentImport;
use Exception;
use yii\console\Controller;
use yii\helpers\Console;

class PaymentController extends Controller
{

    public function actionLoad($path)
    {
        try {
            $json = file_get_contents($path);
            $result = PaymentImport::processJson($json);
        } catch (Exception $e) {
            $this->stdout("Hiba történt az importálás során.\n", Console::BG_RED);
            $this->stdout($e->getMessage() . "\n");
            return 1;
        }
        $this->stdout($result['imported'], Console::BG_GREEN | Console::BOLD);
        $this->stdout(" payment imported. \n", Console::BG_GREEN);
        return 0;
    }
}
