<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{

    public $profile_name;
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
            [['profile_name', 'role_name'], 'string'],
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
        $query = static::find()->joinWith(['profile','role']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'attributes' => [
                    'username',
                    'profile_name' => [
                        'asc'  => ['profile.name' => SORT_ASC],
                        'desc' => ['profile.name' => SORT_DESC],
                    ],
                    'email',
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['created_at' => $this->created_at])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'profile.name', $this->profile_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'auth_assignment.item_name', $this->role_name])
            ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }
}