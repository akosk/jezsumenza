<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gate_event".
 *
 * @property integer $user_id
 * @property integer $gate
 * @property string $create_time
 *
 * @property User $user
 */
class GateEventBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gate_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gate', 'create_time'], 'required'],
            [['user_id', 'gate'], 'integer'],
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
            'gate' => 'Gate',
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
