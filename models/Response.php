<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property string|null $text
 * @property string $date
 * @property string|null $file
 * @property int $task_id
 * @property int $student_id
 *
 * @property User $student
 * @property Task $task
 */
class Response extends \yii\db\ActiveRecord
{
    public $add_files;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['date'], 'safe'],
            [['task_id', 'student_id', 'text'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['task_id', 'student_id', 'status_id'], 'integer'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['student_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']], 
            ['status_id' , 'default', 'value' => 1], 
            [['add_files'], 'file', 'maxFiles' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'date' => 'Дата отправки',
            'add_files' => 'Файл',
            'task_id' => 'Задача',
            'student_id' => 'ФИО студента',
            'status_id' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(User::class, ['id' => 'student_id']);
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

    /** 
     * Gets query for [[ResponseFiles]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getResponseFiles() 
    { 
        return $this->hasMany(ResponseFiles::class, ['response_id' => 'id']); 
    } 
    
    /** 
     * Gets query for [[Status]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getStatus() 
    { 
        return $this->hasOne(Status::class, ['id' => 'status_id']); 
    }

    public function upload()
    {
        if ($this->validate()) {
            
            foreach ($this->add_files as $file) 
            {
                $filename = Yii::$app->user->id . '_' . date('d.m.y.H.i.s') . '_' . $file->baseName . '.' . $file->extension;
                $file->saveAs(Yii::getAlias('@app') . '/web/files/' . $filename);

                $filemodel = new File();
                $filemodel->name = '/files/' . $filename;
                $filemodel->save();

            }
            
            return true;
        } else {
            return false;
        }
    }

    /* public static function getResponseList($task_id)
    {
        return static::find()->select(['student_id'])->indexBy('id')->where(['task_id' => $task_id])->all();  
    } */
}
