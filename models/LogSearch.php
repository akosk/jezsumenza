<?php

namespace app\models;

use app\controllers\GridViewController;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form about `app\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level'], 'integer'],
            [['category', 'prefix', 'message'], 'safe'],
            [['log_time'], 'string'],
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
        $query = Log::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
            'category'=>'public'
        ]);

        if (strlen($this->log_time)>0) {
            list($from,$to)=explode(' - ',$this->log_time);
            if (strlen($from)>0) {
                $from=strtotime($from);
                $query->andFilterWhere(['>=', 'log_time', $from]);
            }
            if (strlen($to)>0) {
                $to=strtotime($to);
                $query->andFilterWhere(['<=', 'log_time', $to]);
            }
        }

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
