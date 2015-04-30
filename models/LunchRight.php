<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lunch_right".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $lunch_date
 * @property string $status
 *
 * @property User $user
 */
class LunchRight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lunch_right';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'lunch_date'], 'required'],
            [['user_id', 'lunch_date'], 'integer'],
            [['status'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'lunch_date' => 'Lunch Date',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
