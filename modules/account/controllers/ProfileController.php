<?php

namespace app\modules\account\controllers;

use app\models\User;
use app\models\ChangePasswordForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;

/**
 * ProfileController implements the CRUD actions for User model.
 */
class ProfileController extends Controller
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
                            'roles' => ['@'],
                        ],
                        [
                            'denyCallback' => function ($rule, $action) {
                                $this->goHome();
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID пользователя
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $success = false;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save(false)) {
            $success = true;
        }
        
        return $this->render('update', [
            'model' => $model,
            'success' => $success,
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $user = $this->findModel(Yii::$app->user->identity->id);
        $alert = false;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->security->validatePassword($model->password, $user->password)){
                $user->password = Yii::$app->security->generatePasswordHash($model->new_password);
                // VarDumper::dump($user->password, 10, true); die;
                $user->save(false);
                $success = true;
                return $this->render('update', [
                    'model' => $user,
                    'success' => $success,
                ]);
                return $this->redirect('update');
            } else {
                $alert = true;
            }
        }

        return $this->render('change-password', [
            'model' => $model,
            'alert' => $alert,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID пользователя
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
