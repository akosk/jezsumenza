<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lunch_right".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $lunch_date
 * @property string $status
 * @property string $create_time
 *
 * @property User $user
 */
class LunchRightBase extends \yii\db\ActiveRecord
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
            [['user_id', 'lunch_date', 'create_time'], 'required'],
            [['user_id'], 'integer'],
            [['lunch_date', 'create_time'], 'safe'],
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
            'create_time' => 'Create Time',
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
