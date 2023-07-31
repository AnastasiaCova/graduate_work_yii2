<?php

namespace app\modules\account\controllers;

use app\models\Task;
use app\models\TaskSearch;
use app\models\Status;
use app\models\Group;
use app\models\StudOfGroup;
use app\models\Subject;
use app\models\File;
use app\models\TaskFiles;
use app\models\Mood;
use app\models\Priority;
use app\models\Reflection;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
                            'roles' => ['per_user'],
                        ],
                        [
                            'denyCallback' => function ($rule, $action) {
                                $this->redirect('/site/main');
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
            );
    
    }

    /**
     * Lists all Task models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $status = Status::getStatusList();
        $subject = Subject::getSubjectList();
        $priority = Priority::getPriorityList();
        $mood = Mood::getMoodList();
        $model = null;
        $reflection = new Reflection();

        if(Yii::$app->user->can('can_admin')) {
            $count = Task::find()->count();
        }

        if(Yii::$app->user->can('per_user')) {
            $count = Task::find()->where(['user_id' => Yii::$app->user->id])->count();
            if (Yii::$app->user->can('per_student') && StudOfGroup::findOne(['student_id' => Yii::$app->user->id])) {
                $count += Task::find()->where(['group_id' => StudOfGroup::findOne(['student_id' => Yii::$app->user->id])->group_id])->count();
            }
        }

        if(Yii::$app->request->isPost)
        {
            $id = Yii::$app->request->get('id');
            $check = Yii::$app->request->get('check');
            
            if ($model = $this->findModel($id)) { 
                switch($check)
                {
                    case 'true' : 
                        $model->status_id = Status::findOne(['title' => 'Выполнено'])->id;
                        $model->checked = 1; 
                        $model->save();
                        break;
                    case 'false' : 
                        $model->status_id = Status::findOne(['title' => 'Не выполнено'])->id;
                        $model->checked = 0;
                        $model->save();
                        break;
                } 
            }

            if ($reflection->load($this->request->post())) {
                
                if ($exist = Reflection::findOne(['task_id' => $id])) {
                    $exist->delete();
                }
                $reflection->task_id = $id;
                $reflection->user_id = Yii::$app->user->id;
                $reflection->save();                   
                return $this->redirect('index');
            }

            if ($model->status->title == 'Не выполнено' && ($ref = Reflection::findOne(['task_id' => $id]))){
                $ref->delete();
            }
        } 

        $not_completed_tasks = Task::find()->where(['status_id' => Status::findOne(['title' => 'Не выполнено'])->id, 'group_id' => null])->all();
        foreach ($not_completed_tasks as $task)
        {
            if ($task->deadline_date){
                if (($task->deadline_date . ' ' . $task->deadline_time) <= date('Y-m-d H:i:s')){
                    $task->status_id = Status::findOne(['title' => 'Просрочено'])->id;
                    $task->save();
                }
            }
            
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status,
            'subject' => $subject,
            'priority' => $priority,
            'model' => $model,
            'count' => $count,
            'reflection' => $reflection,
            'mood' => $mood,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Task();
        $model->user_id = Yii::$app->user->id;
        $model->date = date('Y-m-d');
        $group = Group::getGroupList();
        $subject = Subject::getSubjectList();
        $prompt = '';
        $alert = false;
        
        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->add_files = UploadedFile::getInstances($model, 'add_files');
                if ($model->upload()) {
                    if ($model->group_id != null || $model->important){
                        $model->priority_id = Priority::getIdPriorityName('Важная');
                    } 
                    
                    if ($model->group_id != null) {
                        $model->status_id = Status::findOne(['title' => 'Задача для группы'])->id;
                    }

                    if ($model->deadline_date && !$model->deadline_time){
                        $model->deadline_time = '23:59';
                    } elseif ($model->deadline_time && !$model->deadline_date){
                        $model->deadline_date = date('Y-m-d');
                    }

                    if ($model->save(false)){
                        
                        foreach (UploadedFile::getInstances($model, 'add_files') as $file) {

                            $filename = Yii::$app->user->id . '_' . date('d.m.y.H.i.s') . '_' .$file->name;
                            
                            $taskfiles = new TaskFiles();
                            $taskfiles->task_id = $model->id;
                            $taskfiles->file_id = File::find()->where(['name' => '/files/' . $filename])->one()->id;
                            $taskfiles->save();
                            
                        }

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        } 

        return $this->render('create', [
            'model' => $model,
            'group' => $group,
            'subject' => $subject,
            'prompt' => $prompt,
            'alert' => $alert,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $group = Group::getGroupList();
        $subject = Subject::getSubjectList();
        $model->groupName ? $prompt = $model->groupName->title : $prompt = '';
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
                    
                    if (count($model->add_files) + count(TaskFiles::find()->where(['task_id' => $model->id])->all()) <= 5){

                        if ($model->upload()) {
                            foreach (UploadedFile::getInstances($model, 'add_files') as $file) {
                                $filename = Yii::$app->user->id . '_' . date('d.m.y.H.i.s') . '_' .$file->name;
                                
                                $taskfiles = new TaskFiles();
                                $taskfiles->task_id = $model->id;
                                $taskfiles->file_id = File::find()->where(['name' => '/files/' . $filename])->one()->id;
                                $taskfiles->save(); 
                            }
                        } else {
                            Yii::$app->session->setFlash('error', 'Ошибка при редактировании!');
                            return $this->redirect(['update', 'id' => $id]);
                        }

                    } else {
                        $alert = true;
                        return $this->render('update', [
                            'model' => $model,
                            'group' => $group,
                            'subject' => $subject,
                            'prompt' => $prompt,
                            'alert' => $alert,
                        ]);
                        return $this->redirect(['update', 'id' => $id]);
                    }
                }

                if ($model->group_id != null || $model->important){
                    $model->priority_id = Priority::getIdPriorityName('Важная');
                } else {
                    if (!$model->important) {
                        $model->priority_id = Priority::getIdPriorityName('Повседневная');
                    }
                }

                if ($model->deadline_date && !$model->deadline_time){
                    $model->deadline_time = '23:59';
                } elseif ($model->deadline_time && !$model->deadline_date){
                    $model->deadline_date = date('Y-m-d');
                }

                if ($model->save(false)){
                    $model->group_id = $model->group;
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } 

        return $this->render('update', [
            'model' => $model,
            'group' => $group,
            'subject' => $subject,
            'prompt' => $prompt,
            'alert' => $alert,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
