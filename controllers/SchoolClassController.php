<?php

namespace app\controllers;

use app\models\Profile;
use app\models\User;
use app\models\UserSearch;
use Yii;
use app\models\SchoolClass;
use app\models\SchoolClassSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SchoolClassController implements the CRUD actions for SchoolClass model.
 */
class SchoolClassController extends ControllerBase
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

    /**
     * Lists all SchoolClass models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchoolClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SchoolClass model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new SchoolClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SchoolClass();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SchoolClass model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SchoolClass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAddUsers($id)
    {
        $schoolClass = SchoolClass::findOne($id);

        $searchModel = \Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->searchNonClassUsers($_GET, $schoolClass);

        return $this->render('add-users', [
            'schoolClass'  => $schoolClass,
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    public function actionAddUsersXhr($ids, $school_class_id)
    {
        $allUserId = explode(',', $ids);
        foreach ($allUserId as $user_id) {
            Profile::updateAll(['school_class_id' => $school_class_id], 'user_id=:user_id', [':user_id' => $user_id]);
        }
        $this->redirect(Url::toRoute(['/school-class/add-users','id'=>$school_class_id]));
    }

    /**
     * Finds the SchoolClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SchoolClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SchoolClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
