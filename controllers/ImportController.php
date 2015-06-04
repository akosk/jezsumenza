<?php

namespace app\controllers;

use app\components\PaymentImport;
use Exception;
use Yii;

class ImportController extends ControllerBase
{
    public function actionIndex()
    {
        if (isset($_FILES['attachment'])) {

            $path = $_FILES['attachment']['tmp_name'];
            try {
                $json = file_get_contents($path);
                $json=iconv('ISO-8859-2', 'UTF-8', $json);
                $result = PaymentImport::processJson($json);


            } catch (Exception $e) {
                Yii::$app->getSession()->setFlash('error', "<strong>Hiba!</strong> Hiba történt az importálás során
                .<br/>".$e->getMessage());
            }

            Yii::$app->getSession()->setFlash('success', $result['imported']." befizetés betöltve.");

        }


        return $this->render('index', [
        ]);

    }

}
