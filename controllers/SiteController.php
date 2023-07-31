<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\AuthItem;
use app\models\UserCreateForm;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\VarDumper;
use app\models\Product;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout', 'main'],
                    'rules' => [
                        [
                            'actions' => ['logout', 'main'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        [
                            'denyCallback' => function ($rule, $action) {
                                $this->redirect('/site/login');
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('login');
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/site/main');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMain()
    {
        return $this->render('main');
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($user = $model->registerUser()) {

                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }
        return $this->render('register', compact('model'));
    }

    public function actionUserCreate()
    {
        $model = new UserCreateForm();
        $role = AuthItem::getRoleList();
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($user = $model -> createUser()) {
                return $this->redirect('/admin');
            }
        }
        return $this->render('usercreate', compact('model', 'role'));
    }
}
