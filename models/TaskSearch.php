<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;
use app\models\StudOfGroup;
use yii\helpers\VarDumper;
use Yii;

/**
 * TaskSearch represents the model behind the search form of `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status_id', 'subject_id', 'priority_id'], 'integer'],
            [['title', 'date', 'deadline_date', 'deadline_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if(Yii::$app->user->can('can_admin')) {
            $query = Task::find();
        }

        if(Yii::$app->user->can('per_user')) {
            $query = Task::find()
            ->where(['user_id' => Yii::$app->user->id]);
        }

        if (Yii::$app->user->can('per_student')) {
            if (StudOfGroup::findOne(['student_id' => Yii::$app->user->id])){
                $query = Task::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->orWhere(['group_id' => StudOfGroup::findOne(['student_id' => Yii::$app->user->id])->group_id]);
            }
        }
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'checked' => SORT_ASC,
                    'group_id' => SORT_DESC,
                    'deadline_date' => SORT_DESC,
                    'deadline_time' => SORT_ASC,
                    'priority_id' => SORT_DESC,
                    'date' => SORT_DESC,
                ]
            ],
        ]);    

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            'date' => $this->date,
            'deadline_date' => $this->deadline_date,
            'deadline_time' => $this->deadline_time,
            'status_id' => $this->status_id,
            'subject_id' => $this->subject_id,
            'priority_id' => $this->priority_id,
        ]);

        $query->andFilterWhere(
            ['like', 'title', $this->title],
        );
        

        

        return $dataProvider;
    }
}
