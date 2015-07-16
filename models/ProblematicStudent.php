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

class ProblematicStudent extends Model {

    public $name;
    public $create_time;
    public $problem;
    public $time_from;
    public $time_to;
    public $lunch_right;
    public $between_eating_time;

    public function rules()
    {
        return [
            [['name','time_from', 'time_to', 'lunch_right','between_eating_time','create_time','problem'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Név',
            'time_from' => 'Időponttól',
            'time_to' => 'Időpontig',
        ];
    }

    public function search($params)
    {

        $this->load($params);

        $params = [];
        $where=[];
        $having=[];
        if (strlen($this->name)>0) {
            $params[':name']="%{$this->name}%";
            $where[]='p.name LIKE :name';
        }

        if (strlen($this->create_time)>0) {
            list($from,$to)=explode(' - ',$this->create_time);
            if (strlen($from)>0) {
                $params[':from']="$from";
                $where[]='t.create_time>=:from';
            }
            if (strlen($to)>0) {
                $params[':to']="$to";
                $where[]='t.create_time<=:to';
            }
        }

        switch ($this->problem) {
            case 1:
                $having[]='lunch_right=0';
                break;
            case 2:
                $having[]='between_eating_time=0';
                break;
        }

        $where=count($where)>0? 'WHERE '.implode(' AND ',$where) :'';
        $having=count($having)>0? 'HAVING '.implode(' AND ',$having) :'';

        $q="
    SELECT p.name, t.create_time,lr.id IS NOT NULL lunch_right,
    IF (p.eating_time_start IS NOT NULL AND p.eating_time_end IS NOT NULL,
    time(t.create_time) BETWEEN sc.eating_time_start AND sc.eating_time_end,
    time(t.create_time) BETWEEN sc.eating_time_start AND sc.eating_time_end) between_eating_time
    FROM gate_event t
    INNER JOIN profile p ON p.user_id=t.user_id
    LEFT JOIN lunch_right lr ON lr.user_id=t.user_id AND lr.lunch_date=DATE(t.create_time) AND lr.status='FULL'
    LEFT JOIN school_class sc ON sc.id=p.school_class_id
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
                    'create_time',
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