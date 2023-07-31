<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Response;
use yii\helpers\VarDumper;

/**
 * ResponseSearch represents the model behind the search form of `app\models\Response`.
 */
class ResponseSearch extends Response
{
    public $task_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'status_id'], 'integer'],
            [['text', 'date'], 'safe'],
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
        
        $query = Response::find();//->where(['task_id' => $params['task_id']]);

        //VarDumper::dump($query, 10, true); die;
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
       // $this->load($params, '');
        // VarDumper::dump($params, 10, true);  

        if (!empty($params['task_id'])){
            $this->task_id = $params['task_id'];
        }
       

        // VarDumper::dump($this->attributes, 10, true); die; 

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'date' => $this->date,
            'task_id' => $this->task_id,
            'status_id' => $this->status_id,
        ]);

        // $query->andFilterWhere(['like', 'task_id', $params['id']]);

        return $dataProvider;
    }
}
