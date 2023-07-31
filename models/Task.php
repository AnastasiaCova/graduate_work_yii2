<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $date
 * @property string|null $deadline_date
 * @property string|null $deadline_time
 * @property int $user_id
 * @property int|null $group_id 
 * @property int $status_id
 * @property int|null $subject_id
 * @property int $checked
 * @property int $priority_id 
 *
 * @property Priority $priority 
 * @property Group $group
 * @property Reflection[] $reflections
 * @property Response[] $responses
 * @property Status $status
 * @property Subject $subject
 * @property User $user
 */
class Task extends \yii\db\ActiveRecord
{
    public $group;
    public $add_files;
    public $important;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'date', 'user_id'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['date', 'deadline_date', 'deadline_time'], 'safe'],
            [['deadline_date', 'deadline_time', 'subject_id', 'group', 'priority_id', 'important'] , 'default', 'value' => null], 
            [['priority_id', 'status_id'], 'default', 'value' => 1], 
            [['user_id', 'status_id', 'subject_id', 'group_id', 'checked', 'priority_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::class, 'targetAttribute' => ['subject_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']], 
            [['add_files'], 'file', 'maxFiles' => 5],
            [['priority_id'], 'exist', 'skipOnError' => true, 'targetClass' => Priority::class, 'targetAttribute' => ['priority_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Задача',
            'date' => 'Дата создания',
            'deadline_date' => 'Дата дедлайна',
            'deadline_time' => 'Время дедлайна',
            'user_id' => 'ФИО пользователя',
            'group_id' => 'Группа', 
            'status_id' => 'Статус задачи',
            'subject_id' => 'Предмет',
            'group' => 'Группа',
            'checked' => 'Выполнено',
            'add_files' => 'Файлы',
            'priority_id' => 'Приоритет', 
            'important' => 'Важная', 
        ];
    }

    /**
     * Gets query for [[Reflections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReflections()
    {
        return $this->hasMany(Reflection::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['task_id' => 'id']);
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

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::class, ['id' => 'subject_id']);
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
     * Gets query for [[Priority]]. 
     * 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getPriority() 
    { 
        return $this->hasOne(Priority::class, ['id' => 'priority_id']); 
    }

     /** 
    * Gets query for [[Group]]. 
    * 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getGroup() 
    { 
        return $this->hasOne(Group::class, ['id' => 'group_id']); 
    }

    public function getGroupName()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
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

}
