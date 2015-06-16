<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.06.15.
 * Time: 14:34
 */

namespace app\components;

use Exception;
use Yii;
use yii\db\Connection;

class DinaAuthentication
{

    public $lastUserRole = 'student';

    public $roleMap = [
        'adminisztrátor'  => 'admin',
        'gazdasagi'       => 'economic',
        'helyettes'       => 'teacher',
        'ifjúságvédelmis' => 'teacher',
        'kolistanár'      => 'teacher',
        'kollégium'       => 'teacher',
        'napközi'         => 'teacher',
        'óraadó'          => 'teacher',
        'tanár'           => 'teacher',
        'titkár'          => 'teacher',
    ];

    /**
     * A paramétereknek azért rendhagyó a neve, mert a Dina adatbázisban ilyen néven van felvéve...
     * @param $TanAz tanuló azonosító
     * @param $tanuloazonosito "másik" tanuló azonosító
     * @return bool
     */
    public function authenticate($TanAz, $tanuloazonosito)
    {
        $this->lastUserRole = '';

        $db = Yii::$app->dbDina;
        /**@var Connection $db */

        try {

            $q = "SELECT COUNT(*) FROM dbo.tanulo WHERE dbo.tanulo.TanAz=:tanaz AND dbo.tanulo.tanuloazonosito=:tanuloazonosito";
            $data = $db->createCommand($q, [
                ':tanaz'           => $TanAz,
                ':tanuloazonosito' => $tanuloazonosito
            ])->queryScalar();

            if ($data > 0) {
                $this->lastUserRole = 'student';
                return true;
            }
        } catch (Exception $e) {
        }

        try {
            $q = "SELECT * FROM dbo.Users WHERE (dbo.Users.FelhasznaloNev=:tanaz)
                  AND dbo.Users.Jelszouj=:tanuloazonosito";
            $data = $db->createCommand($q, [
                ':tanaz'           => $TanAz,
                ':tanuloazonosito' => $tanuloazonosito
            ])->queryOne();
            if ($data) {
                $this->lastUserRole = $this->roleMap[$data['Jog']];
                return true;
            }
        } catch (Exception $e) {
        }

        return false;
    }

    public function getEntryByUID($uid)
    {
        $db = Yii::$app->dbDina;
        /**@var Connection $db */

        if ($this->lastUserRole == 'student') {
            $q = "SELECT * FROM dbo.tanulo WHERE dbo.tanulo.TanAz=:uid";
        } else {
            $q = "SELECT * FROM dbo.Users WHERE (dbo.Users.FelhasznaloNev=:uid)";
        }

        $data = $db->createCommand($q, [
            ':uid' => $uid,
        ])->queryOne();
        return $data;
    }
}