<?php

namespace app\modules\forum\controllers;

use Yii;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\db\Query;
use app\modules\forum\models\Forum;
use app\modules\forum\models\ForumSearch;
use app\modules\forum\models\Board;
use app\modules\forum\models\Thread;
use app\modules\forum\models\Broadcast;

/**
 * ForumController implements the CRUD actions for Forum model.
 */
class ForumController extends BaseController
{
    public $layout = 'forum';
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'shiyang\umeditor\UMeditorAction',
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view', 'broadcast', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['view', 'broadcast'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'SELECT COUNT(*) FROM {{%forum}}',
                ],
            ],
        ];
    }

    /**
     * Displays a single Forum model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //该论坛下只有一个版块，且该版块不是分类，则可以直接发帖
        if ($model->boardCount == 1 && $model->boards[0]->parent_id == Board::AS_BOARD ) {
            $newThread = $this->newThread($model->boards[0]->id);
        } else {
            $newThread = null;
        }
        
        return $this->render('view', [
            'model' => $model,
            'newThread' => $newThread,
        ]);
    }
    
    public function actionBroadcast($id)
    {
        $model = $this->findModel($id);
        $newBroadcast = $this->newBroadcast($model->id);
        return $this->render('broadcast', [
            'model' => $model,
            'newBroadcast' => $newBroadcast,
        ]);
    }

    /**
     * Creates a new Forum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = '@app/modules/user/views/layouts/user';
        $model = new Forum();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->forum_url]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Forum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $action='dashboard')
    {
        $model = $this->findModel($id);
        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $newBoard = new Board();
        if ($newBoard->load(Yii::$app->request->post())) {
            $newBoard->forum_id = $model->id;
            if ($newBoard->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
            } else {
                Yii::$app->getSession()->setFlash('error', 'Server error.');
            }
        }
        
        //上传上传图标
        Yii::setAlias('@upload', '@webroot/uploads/forum/icon/');
        if (Yii::$app->request->isPost && !empty($_FILES)) {
            $extension =  strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fileName = $model->id . '_' . time() . rand(1 , 10000) . '.' . $extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 160, 160)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);
            
            //删除旧图标
            if (file_exists(Yii::getAlias('@upload').$model->forum_icon) && (strpos($model->forum_icon, 'default') === false))
                @unlink(Yii::getAlias('@upload').$model->forum_icon); 

            $model->forum_icon = $fileName;
            $model->update();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
        }
        
        return $this->render('update', [
            'model' => $model,
            'newBoard' => $newBoard,
            'action' => $action
        ]);
    }

    /**
     * Finds the Forum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Forum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Forum::findOne(['forum_url' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function newBroadcast($id)
    {
        $newBroadcast = new Broadcast();
        if ($newBroadcast->load(Yii::$app->request->post())) {
            $newBroadcast->forum_id = $id;
            $newBroadcast->save();
            $this->refresh();
        }
        return $newBroadcast;
    }

    protected function newThread($id)
    {
        $newThread = new Thread();
        if ($newThread->load(Yii::$app->request->post())) {
            $newThread->board_id = $id;
            $newThread->save();
            Yii::$app->db->createCommand()->update('{{%forum_board}}', [
                'updated_at' => time(),
                'updated_by' => Yii::$app->user->id
            ], 'id=:id', [':id' => $id])->execute();
            $this->refresh();
        }
        return $newThread;
    }
}
