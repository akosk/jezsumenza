<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food".
 *
 * @property integer $id
 * @property string $category
 * @property string $image
 */
class FoodBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'food';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string'],
            [['image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'image' => 'Kép',
        ];
    }
}
