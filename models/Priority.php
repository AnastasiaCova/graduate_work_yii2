<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "priority".
 *
 * @property int $id
 * @property string $title
 *
 * @property Task[] $tasks
 */
class Priority extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'priority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Приоритет',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['priority_id' => 'id']);
    }

    public static function getPriorityList()
    {
        return static::find()->select(['title'])->indexBy('id')->column();  
    }

    public static function getIdPriorityName($priority_name)
    {
        return static::findOne(['title' => $priority_name])->id;
    }
}
