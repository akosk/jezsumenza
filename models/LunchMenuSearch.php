<?php

namespace app\models;

use app\controllers\GridViewController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LunchMenu;

/**
 * LunchMenuSearch represents the model behind the search form about `app\models\LunchMenu`.
 */
class LunchMenuSearch extends LunchMenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['letter', 'date', 'create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LunchMenu::find();

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'sort'       => ['defaultOrder' => ['create_time' => SORT_DESC]],
            'pagination' => [
                'pageSize' => GridViewController::getPageSize($this->className()),
            ]
        ]);

        $this->load($params);

        if (strlen($this->date) > 0) {
            list($from, $to) = explode(' - ', $this->date);
            if (strlen($from) > 0) {
                $query->andFilterWhere(['>=', 'date', $from]);
            }
            if (strlen($to) > 0) {
                $query->andFilterWhere(['<=', 'date', $to]);
            }
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'id' => $this->id,
//            'date' => $this->date,
//            'create_time' => $this->create_time,
//        ]);

        $query->andFilterWhere(['like', 'letter', $this->letter]);

        return $dataProvider;
    }
}
