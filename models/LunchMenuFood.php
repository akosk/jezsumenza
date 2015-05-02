<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lunch_menu_food".
 *
 * @property integer $lunch_menu_id
 * @property integer $food_id
 *
 * @property LunchMenu $lunchMenu
 * @property Food $food
 */
class LunchMenuFood extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lunch_menu_food';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lunch_menu_id', 'food_id'], 'required'],
            [['lunch_menu_id', 'food_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lunch_menu_id' => 'Lunch Menu ID',
            'food_id' => 'Food ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLunchMenu()
    {
        return $this->hasOne(LunchMenu::className(), ['id' => 'lunch_menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFood()
    {
        return $this->hasOne(Food::className(), ['id' => 'food_id']);
    }
}
