<?php


namespace app\commands;

use app\models\LunchChoice;
use app\models\LunchMenu;
use DateInterval;
use DateTime;
use Exception;
use yii\console\Controller;
use yii\db\Expression;
use yii\helpers\Console;

class AutoOrderController extends Controller
{
    public $date;

    public function actionIndex($date = null)
    {
        $dates = [];
        $date = new DateTime($date);
        $date->modify('next monday');
        $date->format('Y-m-d');
        for ($i = 0; $i < 7; $i++) {
            $dates[] = $date->format('Y-m-d');
            $date->add(new DateInterval('P1D'));
        }

        $allChoiceCount = 0;
        $autoChoiceCount = 0;
        foreach ($dates as $date) {
            $this->stdout("$date : ", Console::BG_PURPLE);
            $lunchMenus = LunchMenu::findAll(['date' => $date]);
            $orderedLunchMenus = [];
            foreach ($lunchMenus as $lunchMenu) {
                $orderedLunchMenus[$lunchMenu->id] = $lunchMenu->getUsersCount();
            }
            asort($orderedLunchMenus);
            $q = "
            SELECT u.id, count(lc.user_id) choosed
            FROM lunch_menu t
            INNER JOIN user u
            LEFT JOIN lunch_choice lc ON lc.user_id=u.id AND lc.lunch_menu_id=t.id
            WHERE t.`date`=:date
            GROUP BY u.username
            HAVING choosed=0
            ";

            $users = \Yii::$app->db->createCommand($q, [':date' => $date])->queryAll();
            $countNotSelected = count($users);
            $allChoiceCount += $countNotSelected;
            $this->stdout("$countNotSelected tanuló nem választott menüt. \n", Console::BG_PURPLE);
            foreach ($users as $user) {
                $lunchChoice = new LunchChoice();
                $lunchChoice->user_id = $user['id'];
                reset($orderedLunchMenus);
                $lunchChoice->lunch_menu_id = key($orderedLunchMenus);
                $lunchChoice->create_time = new Expression('NOW()');
                $lunchChoice->user_selected = 0;
                if ($lunchChoice->save()) {
                    $autoChoiceCount++;
                    $keys = array_keys($orderedLunchMenus);
                    $orderedLunchMenus[$keys[0]]++;
                    asort($orderedLunchMenus);
                } else {
                }
            }
        }

        $this->stdout("$allChoiceCount / $autoChoiceCount", Console::BOLD);
        $this->stdout(" automatikus menüválasztás megtörtént. \n", Console::BG_GREEN);
        return 0;
    }
}
