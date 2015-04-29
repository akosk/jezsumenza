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
            [['eating_time_start', 'eating_time_end'], 'safe'],
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
        ];
    }
}
