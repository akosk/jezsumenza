<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.04.22.
 * Time: 7:15
 */

namespace app\models;



use yii\db\ActiveRecord;

class SchoolClass extends SchoolClassBase{

    public function attributeLabels()
    {
        return [
            'id' => 'Azonosító',
            'name' => 'Név',
            'eating_time_start' => 'Étkezési idősáv kezdete',
            'eating_time_end' => 'Étkezési idősáv vége',
        ];
    }

    public function getProfilesCount()
    {
        return $this->hasMany(Profile::className(), ['school_class_id' => 'id'])->count();
    }
}