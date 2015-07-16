<?php

namespace app\models;

use app\controllers\GridViewController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Food;
use yii\data\SqlDataProvider;

/**
 * FoodSearch represents the model behind the search form about `app\models\Food`.
 */
class FoodSearch extends Food
{

    public $name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
            [['category'], 'safe'],
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
        $query = Food::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'       => [
                'attributes' => [
                    'id',
                    'name',
                ],
            ],
            'pagination' => [
                'pageSize' => GridViewController::getPageSize($this->className()),
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['huTranslations']);
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category]);
        $query->andFilterWhere(['like', 'food_translation.name', $this->name]);

        return $dataProvider;
    }

    public function searchFoodStat($params)
    {

        $this->load($params);

        $params = [];
        $where=[];
        if (strlen($this->name)>0) {
            $params[':name']="%{$this->name}%";
            $where[]='name LIKE :name';
        }

        $where=count($where)>0? 'WHERE '.implode(' AND ',$where) :'';

        $q = "
        SELECT ft.name name, COUNT(lc.lunch_menu_id) db
        FROM food t
        INNER JOIN food_translation ft ON ft.language='hu-HU' AND ft.food_id=t.id
        LEFT JOIN lunch_menu_food lmf ON lmf.food_id=t.id
        LEFT JOIN lunch_choice lc ON lc.lunch_menu_id=lmf.lunch_menu_id
        {$where}
        GROUP BY t.category, ft.name
        ";



        $count = Yii::$app->db
            ->createCommand("SELECT COUNT(*) FROM ($q) t", $params)
            ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql'        => $q,
            'params'     => $params,
            'totalCount' => $count,
            'sort'       => [
                'attributes' => [
                    'name',
                    'db',
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
            'pagination' => [
                'pageSize' => GridViewController::getPageSize($this->className()),
            ]
        ]);

        return $dataProvider;
    }
}
