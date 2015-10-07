<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school_class".
 *
 * @property integer $id
 * @property string $name
 * @property string $eating_time_start
 * @property string $eating_time_end
 * @property string $eating_time_start_weekday_1
 * @property string $eating_time_end_weekday_1
 * @property string $eating_time_start_weekday_2
 * @property string $eating_time_end_weekday_2
 * @property string $eating_time_start_weekday_3
 * @property string $eating_time_end_weekday_3
 * @property string $eating_time_start_weekday_4
 * @property string $eating_time_end_weekday_4
 * @property string $eating_time_start_weekday_5
 * @property string $eating_time_end_weekday_5
 *
 * @property Profile[] $profiles
 */
class SchoolClassBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['eating_time_start', 'eating_time_end', 'eating_time_start_weekday_1', 'eating_time_end_weekday_1', 'eating_time_start_weekday_2', 'eating_time_end_weekday_2', 'eating_time_start_weekday_3', 'eating_time_end_weekday_3', 'eating_time_start_weekday_4', 'eating_time_end_weekday_4', 'eating_time_start_weekday_5', 'eating_time_end_weekday_5'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'eating_time_start' => 'Eating Time Start',
            'eating_time_end' => 'Eating Time End',
            'eating_time_start_weekday_1' => 'Eating Time Start Weekday 1',
            'eating_time_end_weekday_1' => 'Eating Time End Weekday 1',
            'eating_time_start_weekday_2' => 'Eating Time Start Weekday 2',
            'eating_time_end_weekday_2' => 'Eating Time End Weekday 2',
            'eating_time_start_weekday_3' => 'Eating Time Start Weekday 3',
            'eating_time_end_weekday_3' => 'Eating Time End Weekday 3',
            'eating_time_start_weekday_4' => 'Eating Time Start Weekday 4',
            'eating_time_end_weekday_4' => 'Eating Time End Weekday 4',
            'eating_time_start_weekday_5' => 'Eating Time Start Weekday 5',
            'eating_time_end_weekday_5' => 'Eating Time End Weekday 5',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['school_class_id' => 'id']);
    }
}
