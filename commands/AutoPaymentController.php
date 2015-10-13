<?php


namespace app\commands;

use app\components\PaymentImport;
use app\models\ImportedFile;
use Exception;
use Yii;
use yii\console\Controller;
use yii\db\Expression;
use yii\helpers\Console;

class AutoPaymentController extends Controller
{

    public function actionHello()
    {
        Yii::info("Hello!", 'public');
    }

    public function actionLoad()
    {

        Yii::info("Befizetések autimatikus importálása...", 'public');
        Yii::getLogger()->flush();

        $paymentController = new PaymentController('payment', $this->module);

        $dir=\Yii::$app->params['payment_import_dir'];
        $files = array_diff(scandir($dir, 0), ['..', '.']);

        foreach ($files as $file) {
            if (preg_match('/.json/', $file) == 1) {
                $alreadyImported = ImportedFile::find()->where('filename=:filename', [
                        ':filename' => $file
                    ])->count() > 0;
                if ($alreadyImported) {
                    Yii::info("{$file} már importálva van.", 'public');
                    echo "{$file} már importálva van. \n";
                } else {
                    Yii::info("{$file} még nincs importálva...", 'public');
                    echo "{$file} még nincs importálva... \n";
                    if ($paymentController->actionLoad($dir . $file) == 0) {
                        $importedFile = new ImportedFile();
                        $importedFile->filename = $file;
                        $importedFile->create_time = new Expression('NOW()');
                        $importedFile->save();
                    }
                }
            }
        }

        Yii::info("Befizetések autimatikus importálása vége.", 'public');

        return 0;
    }
}
