<?php

namespace app\models;

use app\components\ArChangeLoggerBehavior;
use Yii;

/**
 * This is the model class for table "food_translation".
 *
 * @property integer $food_id
 * @property string $language
 * @property string $name
 * @property string $description
 */
class FoodTranslation extends \yii\db\ActiveRecord
{

    public function behaviors()
    {

        return [
            [
                'class'   => ArChangeLoggerBehavior::className(),
                'logClassName' => 'étel fordítás',
                'primaryKey'=>'food_id',
                'logNameProperty' => function () {
                    return $this->name;
                },
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'food_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language', 'name', 'description'], 'required'],
            [['food_id'], 'integer'],
            [['description'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'food_id' => 'Azonosító',
            'language' => 'Nyelv',
            'name' => 'Név',
            'description' => 'Leírás',
        ];
    }
}
