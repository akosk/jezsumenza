<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $year
 * @property integer $month
 * @property integer $amounth
 *
 * @property User $user
 */
class PaymentBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'year', 'month', 'amounth'], 'required'],
            [['user_id', 'year', 'month', 'amounth'], 'integer']
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
            'year' => 'Year',
            'month' => 'Month',
            'amounth' => 'Amounth',
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
