<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reflection".
 *
 * @property int $id
 * @property string $date
 * @property int $task_id
 * @property int $mood_id
 * @property int $user_id 
 *
 * @property Mood $mood
 * @property Task $task
 * @property User $user 
 */
class Reflection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reflection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id', 'mood_id'], 'required'],
            [['date'], 'safe'],
            [['user_id', 'task_id', 'mood_id'], 'integer'],
            [['mood_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mood::class, 'targetAttribute' => ['mood_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата создания',
            'user_id' => 'ФИО пользователя', 
            'task_id' => 'Задача',
            'mood_id' => 'Настроение',
        ];
    }

    /** 
    * Gets query for [[User]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getUser() 
    { 
        return $this->hasOne(User::class, ['id' => 'user_id']); 
    } 

    /**
     * Gets query for [[Mood]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMood()
    {
        return $this->hasOne(Mood::class, ['id' => 'mood_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
