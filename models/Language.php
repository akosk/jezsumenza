<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.04.30.
 * Time: 8:41
 */
namespace app\models;

use Yii;
use yii\base\Model;

class Language extends Model {

    public static $languages= [
      'hu'=> [
          'code'=>'hu-HU',
          'name'=>'Magyar',
      ],
      'gb'=> [
          'code'=>'en-US',
          'name'=>'Angol',
      ],
      'de'=> [
          'code'=>'de-DE',
          'name'=>'Német',
      ],
      'fr'=> [
          'code'=>'fr-FR',
          'name'=>'Francia',
      ],
      'cn'=> [
          'code'=>'zh-CN',
          'name'=>'Kínai',
      ],
    ];

    public static function getAsDropdownData()
    {
        $data=[];
        foreach(self::$languages as $key=>$value) {
            $data[$value['code']]=$value['name'];
        }
        return $data;
    }
}