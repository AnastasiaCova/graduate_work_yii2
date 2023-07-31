<?php

namespace app\modules\account\controllers;

use app\models\Reflection;
use app\models\Mood;
use app\models\ReflectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;

/**
 * ReflectionController implements the CRUD actions for Reflection model.
 */
class ReflectionController extends Controller
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
     * Lists all Reflection models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReflectionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = Reflection::findAll(['user_id' => Yii::$app->user->id]);
        $mood = Mood::getMoodList();
        $moods = [];
        $statistic = [];

        foreach ($model as $m) {
            $moods[] = $m->mood_id;  
        }

        $a = array_fill(0, 5, 0);
        $statistic = array_replace($a, array_count_values($moods));

        // VarDumper::dump( $statistic, 10, true); die;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statistic' => $statistic,
            'mood' => $mood,
        ]);
    }

    /**
     * Finds the Reflection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reflection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reflection::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
