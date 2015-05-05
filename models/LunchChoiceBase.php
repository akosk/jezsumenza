<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lunch_choice".
 *
 * @property integer $user_id
 * @property integer $lunch_menu_id
 * @property string $create_time
 * @property integer $user_selected
 *
 * @property User $user
 * @property LunchMenu $lunchMenu
 */
class LunchChoiceBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lunch_choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lunch_menu_id', 'create_time', 'user_selected'], 'required'],
            [['lunch_menu_id', 'user_selected'], 'integer'],
            [['create_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'lunch_menu_id' => 'Lunch Menu ID',
            'create_time' => 'Create Time',
            'user_selected' => 'User Selected',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLunchMenu()
    {
        return $this->hasOne(LunchMenu::className(), ['id' => 'lunch_menu_id']);
    }
}
