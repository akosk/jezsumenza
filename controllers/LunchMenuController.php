<?php

namespace app\controllers;

use app\models\Food;
use app\models\LunchChoice;
use app\models\LunchMenuFood;
use app\models\LunchMenuSearch;
use app\models\User;
use Exception;
use Yii;
use app\models\LunchMenu;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LunchMenuController implements the CRUD actions for LunchMenu model.
 */
class LunchMenuController extends ControllerBase
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionUsers($id)
    {
        $model = LunchMenu::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query'      => LunchChoice::find()->where(['lunch_menu_id' => $id]),
            'pagination' => [
                'pageSize' => GridViewController::getPageSize($this->className()),
            ]
        ]);

        return $this->render('users', [
            'model'        => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBulkDelete($ids)
    {
        LunchMenu::deleteAll([
            'id' => explode(',', $ids),
        ]);

        $this->redirect(Url::toRoute('/lunch-menu/index'));
    }

    public function actionBulkDeleteChoices($lunch_menu_id, $user_ids)
    {
        LunchChoice::deleteAll([
            'user_id'       => explode(',', $user_ids),
            'lunch_menu_id' => $lunch_menu_id,
        ]);

        $this->redirect(Url::toRoute('/lunch-menu/index'));
    }

    public function actionSearchUsers()
    {
        $q=is_array($_GET['q'])?$_GET['q']['term']:$_GET['q'];
        $users = User::find()
            ->innerJoinWith(['profile'])
            ->where('profile.name LIKE :q AND user.inactive<>1', [':q' => '%' . $q . '%'])
            ->limit(10)
            ->asArray()
            ->all();

        $data = array_reduce($users, function ($carry, $item) {
            $carry[] = [
                'id'       => $item['id'],
                'name'     => $item['profile']['name'],
                'username' => $item['username']
            ];
            return $carry;
        }, []);
        $json = Json::encode(['results'=>$data]);
        echo $json;
    }

    public function actionAddUserToMenu($id)
    {

        $lunchMenu = LunchMenu::findOne($id);
        if (!$lunchMenu) {
            throw new NotFoundHttpException('Nincs ilyen azonosítójú ebéd menü');
        }
        if (isset($_POST['User'])) {
            $lunchChoice = new LunchChoice();
            $lunchChoice->user_id = $_POST['User']['id'];
            $lunchChoice->lunch_menu_id = $id;
            $lunchChoice->user_selected = 0;
            $lunchChoice->create_time = new Expression('NOW()');
            if ($lunchChoice->save()) {
                $this->redirect(Url::toRoute(['/lunch-menu/users', 'id' => $id]));
                Yii::$app->end();
            }
        }

        $model = new User();
        return $this->render('add_user_to_menu', [
            'model'     => $model,
            'lunchMenu' => $lunchMenu
        ]);
    }

    /**
     * Lists all LunchMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $lunchMenu = new LunchMenu;
//
//        $query = LunchMenu::find()->innerJoinWith(['foodsSorted']);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort'       => [
//                'attributes' => [
//                    'date',
//                    'letter',
//                ],
//            ],
//        ]);

        $searchModel = new LunchMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LunchMenu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LunchMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LunchMenu();
        $model->date = date('Y-m-d');

        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (Exception $e) {
            $errorMsg = (count($model->formFoods) !== count(array_unique($model->formFoods))) ?
                "Egy étel csak egyszer szerepelhet a menüben."
                :
                "Már létezik a megadott napra ilyen betű-kódú menü";

            Yii::$app->getSession()->setFlash('error', "<strong>Hiba!</strong> $errorMsg");
        }

        $foods = BaseArrayHelper::map(Food::find()->all(), 'id', function ($data) {
            return $data->translate(Yii::$app->language)->name;
        });

        asort($foods);

        return $this->render('create', [
            'model' => $model,
            'foods' => $foods,
        ]);
    }

    public function actionCreateDaily()
    {
        $modelA = new LunchMenu();
        $modelB = new LunchMenu();
        $modelC = new LunchMenu();

        $modelA->date = date('Y-m-d');

        try {

            if ($modelA->load(Yii::$app->request->post())) {

                $modelA->letter = 'A';
                $modelB->letter = 'B';
                $modelC->letter = 'C';

                $modelB->date = $modelA->date;
                $modelC->date = $modelA->date;
                $modelB->formFoods[0] = $modelA->formFoods[2];
                $modelB->formFoods[1] = $modelA->formFoods[3];
                $modelC->formFoods[0] = $modelA->formFoods[4];
                $modelC->formFoods[1] = $modelA->formFoods[5];
                $modelA->formFoods = array_slice($modelA->formFoods, 0, 2);

                if ($modelA->save() && $modelB->save() && $modelC->save()) {
                    return $this->redirect(['index']);
                }
            }
        } catch (Exception $e) {
            $errorMsg = (count($modelA->formFoods) !== count(array_unique($modelA->formFoods))) ?
                "Egy étel csak egyszer szerepelhet a menüben."
                :
                "Már létezik a megadott napra ilyen betű-kódú menü";

            Yii::$app->getSession()->setFlash('error', "<strong>Hiba!</strong> $errorMsg");
        }

        $foods = BaseArrayHelper::map(Food::find()->all(), 'id', function ($data) {
            return $data->translate(Yii::$app->language)->name;
        });
        asort($foods);

        return $this->render('create_daily', [
            'modelA' => $modelA,
            'modelB' => $modelB,
            'modelC' => $modelC,
            'foods'  => $foods,
        ]);
    }

    /**
     * Updates an existing LunchMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $foods = BaseArrayHelper::map(Food::find()->all(), 'id', function ($data) {
                return $data->translate(Yii::$app->language)->name;
            });

            return $this->render('update', [
                'model' => $model,
                'foods' => $foods
            ]);
        }
    }

    /**
     * Deletes an existing LunchMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LunchMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LunchMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LunchMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteSelection($user_id, $lunch_menu_id)
    {
        LunchChoice::deleteAll('user_id=:user_id AND lunch_menu_id=:lunch_menu_id', [
            ':user_id'       => $user_id,
            ':lunch_menu_id' => $lunch_menu_id,
        ]);
        return $this->redirect(['lunch-menu/users', 'id' => $lunch_menu_id]);
    }
}
