<?php

namespace app\models;


use app\components\ArChangeLoggerBehavior;
use creocoder\translateable\TranslateableBehavior;

/**
 * This is the model class for table "food".
 *
 * @property string $name
 * @property string $description
 */

class Food extends FoodBase{

    const CATEGORY_SOUP="SOUP";
    const CATEGORY_MAIN_COURSE="MAIN_COURSE";

    public function behaviors()
    {

        return [
            'translateable' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => ['name', 'description'],
                // translationRelation => 'translations',
                // translationLanguageAttribute => 'language',
            ],
            [
                'class'   => ArChangeLoggerBehavior::className(),
                'logClassName' => 'étel',
                'logNameProperty' => function () {
                    return $this->name;
                },
            ]
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(FoodTranslation::className(), ['food_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}