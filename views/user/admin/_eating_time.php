<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.10.09.
 * Time: 8:55
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */

use app\components\DateHelper;
use app\models\Language;
use app\models\SchoolClass;
use kartik\widgets\TimePicker;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;


echo Form::widget([
    'model'      => $profile,
    'form'       => $form,
    'columns'    => 1,
    'attributes' => [
        'time_range' => [
            'label'      => 'Egyéni étkezési idősáv',
            'attributes' => [
                "eating_time_start" => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TimePicker',

                    'options'     => [
                        'options'       => ['placeholder' => 'Időponttól...',
                        ],
                        'pluginOptions' => [
                            'showSeconds'  => false,
                            'showMeridian' => false,
                            'defaultTime'  => false
                        ]

                    ],
                ],
                "eating_time_end"   => [
                    'type'        => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\TimePicker',
                    'options'     => [
                        'options'       => ['placeholder' => 'Időpontig...'],
                        'pluginOptions' => [
                            'showSeconds'  => false,
                            'showMeridian' => false,
                            'defaultTime'  => false
                        ]]
                ],
            ]
        ]
    ]
]);

for ($i = 1; $i < 6; $i++) {

    echo Form::widget([
        'model'      => $profile,
        'form'       => $form,
        'columns'    => 1,
        'attributes' => [
            'time_range' => [
                'label'      => 'Egyéni étkezési idősáv - ' . Yii::t('app', DateHelper::$DAY_NAMES[$i]),
                'attributes' => [
                    "eating_time_start_weekday_{$i}" => [
                        'type'        => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\TimePicker',

                        'options'     => [
                            'options'       => ['placeholder' => 'Időponttól...',
                            ],
                            'pluginOptions' => [
                                'showSeconds'  => false,
                                'showMeridian' => false,
                                'defaultTime'  => false
                            ]

                        ],
                    ],
                    "eating_time_end_weekday_{$i}"   => [
                        'type'        => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\TimePicker',
                        'options'     => [
                            'options'       => ['placeholder' => 'Időpontig...'],
                            'pluginOptions' => [
                                'showSeconds'  => false,
                                'showMeridian' => false,
                                'defaultTime'  => false
                            ]]
                    ],
                ]
            ]
        ]
    ]);
}
?>
