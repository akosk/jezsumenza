<?php


namespace app\commands;

use app\components\PaymentImport;
use app\models\Food;
use app\models\Language;
use Exception;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class FoodImportController extends Controller
{

    public function actionDb()
    {
        $q = "
            SELECT * FROM menu_etelek t
            LEFT JOIN food_translation ft ON ft.name=t.nev
            WHERE ft.food_id IS NULL
            ";

        $data = Yii::$app->db->createCommand($q)->queryAll();
        foreach ($data as $item) {
            $food = new Food();
            $food->category = $item['fogas'] == 'leves' ? Food::CATEGORY_SOUP : Food::CATEGORY_MAIN_COURSE;
            foreach (Language::$languages as $language) {
                $food->translate($language['code'])->name = $item['nev'];
                $food->translate($language['code'])->description = $item['recept'] == '' ? '-' : $item['recept'];
            }
            $food->save();
        }
    }
}
