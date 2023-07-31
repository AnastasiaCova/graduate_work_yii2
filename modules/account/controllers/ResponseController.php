<?php

namespace app\modules\account\controllers;

use app\models\Response;
use app\models\Status;
use app\models\Task;
use app\models\ResponseFiles;
use app\models\File;
use app\models\User;
use app\models\ResponseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use Yii;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ResponseController implements the CRUD actions for Response model.
 */
class ResponseController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['can_admin', 'per_user'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['can_admin', 'per_manager', 'per_head_teacher'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete'],
                            'roles' => ['per_student'],
                        ],
                        [
                            'denyCallback' => function ($rule, $action) {
                                $this->redirect('/account/task');
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Response models.
     *
     * @return string
     */
    public function actionIndex()
    {
       
        $searchModel = new ResponseSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $status = Status::getResponseStatusList();
        $task_id = Yii::$app->request->get('task_id');

        if ($task_id == null){
            $task_id = Yii::$app->request->get()['ResponseSearch']['task_id'];
        }

        $no_reply = User::getNoReplyStudentList($task_id, Task::findOne($task_id)->group_id);
        $count = Response::find()->where(['task_id' => $task_id])->count();

        $not_completed_responses = Response::find()->where(['status_id' => Status::findOne(['title' => 'Не выполнено'])->id])->all();
        foreach ($not_completed_responses as $resp)
        {
            if (Task::findOne(['id' => $resp->task_id])->deadline_date) {
                $deadline = Task::findOne(['id' => $resp->task_id])->deadline_date . ' ' . Task::findOne(['id' => $resp->task_id])->deadline_time;

                // VarDumper::dump($resp->date . ' = ' . $deadline, 10, true); die; 

                if ($resp->date >= $deadline){
                    $resp->status_id = Status::findOne(['title' => 'Просрочено'])->id;
                    $resp->save();
                } elseif ($resp->date < $deadline) {
                    $resp->status_id = Status::findOne(['title' => 'Выполнено'])->id;
                    $resp->save();
                }
            } else {
                $resp->status_id = Status::findOne(['title' => 'Выполнено'])->id;
                $resp->save();
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
            'count' => $count,
            'no_reply' => $no_reply,
            'task_id' =>  $task_id,
        ]);
    }

    /**
     * Displays a single Response model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $resp = Response::findOne($id);
        $confirm_response_id = Yii::$app->request->get('confirm_response_id');
        $no_confirm_response_id = Yii::$app->request->get('no_confirm_response_id');

        if ($resp->status_id == Status::findOne(['title' => 'Не выполнено']) || $no_confirm_response_id) {
            if (Task::findOne(['id' => $resp->task_id])->deadline_date) {
                $deadline = Task::findOne(['id' => $resp->task_id])->deadline_date . ' ' . Task::findOne(['id' => $resp->task_id])->deadline_time;

                // VarDumper::dump($resp->date . ' = ' . $deadline, 10, true); die; 

                if ($resp->date >= $deadline){
                    $resp->status_id = Status::findOne(['title' => 'Просрочено'])->id;
                    $resp->save();
                } elseif ($resp->date < $deadline) {
                    $resp->status_id = Status::findOne(['title' => 'Выполнено'])->id;
                    $resp->save();
                }
            } else {
                $resp->status_id = Status::findOne(['title' => 'Выполнено'])->id;
                $resp->save();
            }
            return $this->redirect(['view', 'id' => $id]);
        } else {
            if ($confirm_response_id) { 
                // VarDumper::dump($response_id, 10, true); die;
                $resp->status_id = Status::findOne(['title' => 'Проверено'])->id;
                $resp->save();
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Response model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new Response();
        $model->student_id = Yii::$app->user->id;
        $model->task_id = $id;
        $alert = false;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->add_files = UploadedFile::getInstances($model, 'add_files');
                if ($model->upload()) {
                    if ($model->save(false)){
                        
                        foreach (UploadedFile::getInstances($model, 'add_files') as $file) {

                            $filename = Yii::$app->user->id . '_' . date('d.m.y.H.i.s') . '_' .$file->name;
                            
                            $respfiles = new ResponseFiles();
                            $respfiles->response_id = $model->id;
                            $respfiles->file_id = File::find()->where(['name' => '/files/' . $filename])->one()->id;
                            $respfiles->save();
                            
                        }

                        // VarDumper::dump($model, 10, true); die;

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        } 

        return $this->render('create', [
            'model' => $model,
            'alert' => $alert,
        ]);
    }

    /**
     * Updates an existing Response model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $alert = false;

        if ($this->request->isPost) {
            $id = Yii::$app->request->get('id');
            $file_id = Yii::$app->request->get('file');
            
            if ($file_id) { 
                $delete = File::findOne($file_id);
                unlink(Yii::getAlias('@app') . '/web' . $delete->name);
                $delete->delete();
                return $this->redirect(['update', 'id' => $id]);
            }

            if ($model->load($this->request->post())) {
                $model->add_files = UploadedFile::getInstances($model, 'add_files');
                
                if ($model->add_files){
                    
                    if (count($model->add_files) + count(ResponseFiles::find()->where(['response_id' => $model->id])->all()) <= 5){

                        if ($model->upload()) {
                            foreach (UploadedFile::getInstances($model, 'add_files') as $file) {
                                $filename = Yii::$app->user->id . '_' . date('d.m.y.H.i.s') . '_' .$file->name;
                                
                                $respfiles = new ResponseFiles();
                                $respfiles->response_id = $model->id;
                                $respfiles->file_id = File::find()->where(['name' => '/files/' . $filename])->one()->id;
                                $respfiles->save(); 
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'Ошибка при редактировании!');
                            return $this->redirect(['update', 'id' => $id]);
                        }

                    } else {
                        $alert = true;
                        return $this->render('update', [
                            'model' => $model,
                            'alert' => $alert,
                        ]);
                        return $this->redirect(['update', 'id' => $id]);
                    }
                }

                if ($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } 

        return $this->render('update', [
            'model' => $model,
            'alert' => $alert,
        ]);
    }

    /**
     * Deletes an existing Response model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->goHome();
    }

    /**
     * Finds the Response model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Response the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Response::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
