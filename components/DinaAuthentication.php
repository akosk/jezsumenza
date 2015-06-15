<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.06.15.
 * Time: 14:34
 */

namespace app\components;

use Yii;
use yii\db\Connection;

class DinaAuthentication
{

    /**
     * A paramétereknek azért rendhagyó a neve, mert a Dina adatbázisban ilyen néven van felvéve...
     * @param $TanAz tanuló azonosító
     * @param $tanuloazonosito "másik" tanuló azonosító
     * @return bool
     */
    public function authenticate($TanAz, $tanuloazonosito)
    {
        $db = Yii::$app->dbDina;
        /**@var Connection $db */

        $q = "SELECT COUNT(*) FROM dbo.tanulo WHERE dbo.tanulo.TanAz=:tanaz AND dbo.tanulo.tanuloazonosito=:tanuloazonosito";

        $data = $db->createCommand($q, [
            ':tanaz'           => $TanAz,
            ':tanuloazonosito' => $tanuloazonosito
        ])->queryScalar();

        return $data > 0;
    }

    public function getEntryByUID($uid)
    {
        $db = Yii::$app->dbDina;
        /**@var Connection $db */

        $q = "SELECT * FROM dbo.tanulo WHERE dbo.tanulo.TanAz=:uid";

        $data = $db->createCommand($q, [
            ':tanaz'           => $uid,
        ])->queryOne();
        return $data;
    }
}