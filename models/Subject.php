<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property int $id
 * @property string $title
 *
 * @property Task[] $tasks
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique', 'targetClass'=>Subject::class, 'message'=>'Такой предмет уже существует.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название предмета',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['subject_id' => 'id']);
    }

    public static function getSubjectList()
    {
        return static::find()->select(['title'])->indexBy('id')->orderBy('title ASC')->column();  
    }
}
