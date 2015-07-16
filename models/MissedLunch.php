<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.05.29.
 * Time: 21:52
 */

namespace app\models;


use app\controllers\GridViewController;
use Yii;
use yii\base\Model;
use yii\data\SqlDataProvider;

class MissedLunch extends Model {

    public $name;
    public $lunch_date;
    public $problem;
    public $time_from;
    public $time_to;
    public $lunch_right;
    public $between_eating_time;

    public function rules()
    {
        return [
            [['name','lunch_date'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Név',
            'create_time' => 'Időpont',
        ];
    }

    public function search($params)
    {

        $this->load($params);

        $params = [];
        $where=['ge.user_id IS NULL'];
        $having=[];
        if (strlen($this->name)>0) {
            $params[':name']="%{$this->name}%";
            $where[]='p.name LIKE :name';
        }

        if (strlen($this->lunch_date)>0) {
            list($from,$to)=explode(' - ',$this->lunch_date);
            if (strlen($from)>0) {
                $params[':from']="$from";
                $where[]='t.lunch_date>=:from';
            }
            if (strlen($to)>0) {
                $params[':to']="$to";
                $where[]='t.lunch_date<=:to';
            }
        }


        $where=count($where)>0? 'WHERE '.implode(' AND ',$where) :'';
        $having=count($having)>0? 'HAVING '.implode(' AND ',$having) :'';

        $q="
SELECT p.name, t.lunch_date
FROM lunch_right t
INNER JOIN profile p ON p.user_id=t.user_id
LEFT JOIN gate_event ge ON date(ge.create_time)=t.lunch_date AND ge.user_id=t.user_id AND ge.gate=2
    {$where}
    {$having}
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
                    'lunch_date',
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