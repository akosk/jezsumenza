<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lunch_menu".
 *
 * @property integer $id
 * @property string $letter
 * @property string $date
 * @property string $create_time
 *
 * @property LunchMenuFood[] $lunchMenuFoods
 * @property Food[] $foods
 */
class LunchMenuBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lunch_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['letter', 'date', 'create_time'], 'required'],
            [['date', 'create_time'], 'safe'],
            [['letter'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'letter' => 'Letter',
            'date' => 'Date',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLunchMenuFoods()
    {
        return $this->hasMany(LunchMenuFood::className(), ['lunch_menu_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoods()
    {
        return $this->hasMany(Food::className(), ['id' => 'food_id'])->viaTable('lunch_menu_food', ['lunch_menu_id' => 'id']);
    }
}
