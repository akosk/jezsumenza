<?php

namespace app\models;

use app\controllers\GridViewController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{

    public $profile_name;
    public $profile_yami_id;
    public $profile_barcode;
    public $role_name;

    /** @inheritdoc */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['profile_name', 'role_name', 'inactive','profile_yami_id', 'profile_barcode'], 'string'],
            [['username', 'email', 'registration_ip'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'username'        => \Yii::t('user', 'Username'),
            'email'           => \Yii::t('user', 'Email'),
            'created_at'      => \Yii::t('user', 'Registration time'),
            'registration_ip' => \Yii::t('user', 'Registration ip'),
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find()->joinWith(['profile', 'role']);

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => [
                'attributes' => [
                    'username',
                    'inactive',
                    'profile_name' => [
                        'asc'  => ['profile.name' => SORT_ASC],
                        'desc' => ['profile.name' => SORT_DESC],
                    ],
                    'profile_yami_id' => [
                        'asc'  => ['profile.yami_id' => SORT_ASC],
                        'desc' => ['profile.yami_id' => SORT_DESC],
                    ],
                    'profile_barcode' => [
                        'asc'  => ['profile.barcode' => SORT_ASC],
                        'desc' => ['profile.barcode' => SORT_DESC],
                    ],
                    'email',
                ],
            ],
            'pagination' => [
                'pageSize' => GridViewController::getPageSize($this->className()),
            ]
        ]);

        $this->inactive=0;
        if (!($this->load($params) && $this->validate())) {
            $query->andFilterWhere(['inactive'=> $this->inactive]);
            return $dataProvider;
        }

        $query->andFilterWhere(['created_at' => $this->created_at])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'profile.name', $this->profile_name])
            ->andFilterWhere(['like', 'profile.yami_id', $this->profile_yami_id])
            ->andFilterWhere(['like', 'profile.barcode', $this->profile_barcode])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['inactive'=> $this->inactive])
            ->andFilterWhere(['like', 'auth_assignment.item_name', $this->role_name])
            ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }

    public function searchNonClassUsers($params, $schoolClass)
    {
        $query = static::find()->joinWith(['profile', 'role']);

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => [
                'attributes' => [
                    'username',
                    'profile_name' => [
                        'asc'  => ['profile.name' => SORT_ASC],
                        'desc' => ['profile.name' => SORT_DESC],
                    ],
                    'email',
                ],
            ],
            'pagination' => [
                'pageSize' => GridViewController::getPageSize($this->className()),
            ]
        ]);
        $query->andOnCondition('inactive<>1');
        $query->andOnCondition('school_class_id IS NULL');
        $query->andOnCondition("auth_assignment.item_name='student'");

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['created_at' => $this->created_at])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_assignment.item_name', $this->role_name])
            ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }
}