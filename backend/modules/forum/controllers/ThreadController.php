<?php

namespace backend\modules\forum\controllers;

use Yii;
use backend\modules\forum\models\Thread;
use backend\modules\forum\models\ThreadSearch;
use backend\modules\forum\models\Post;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * ThreadController implements the CRUD actions for Thread model.
 */
class ThreadController extends BaseController
{
    public $layout = 'forum';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'shiyang\umeditor\UMeditorAction',
            ]
        ];
    }

    /**
     * Lists all Thread models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThreadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    
    /**
     * Displays a single Thread model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $newPost = new Post();
        
        if ($newPost->load(Yii::$app->request->post())) {
            $newPost->thread_id = $model->id;
            if ($newPost->save()){
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 

        return $this->render('view', [
            'model' => $model,
            'newPost' => $newPost,
        ]);
    }

    /**
     * Creates a new Thread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Thread();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Thread model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Thread model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $board_id = $model->board_id;
        Post::deleteAll(['thread_id' => $model->id]);
        $model->delete();
        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Deleted successfully.'));
        return $this->redirect(['/forum/thread/index']);
    }

    /**
     * Finds the Thread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thread the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Thread::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
