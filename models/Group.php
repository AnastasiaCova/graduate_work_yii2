<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $title
 * @property int $manager_id
 *
 * @property User $manager
 * @property StudOfGroup[] $studOfGroups
 * @property Task[] $tasks 
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'manager_id'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['manager_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '№ Группы',
            'manager_id' => 'Куратор группы',
        ];
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::class, ['id' => 'manager_id']);
    }

    /**
     * Gets query for [[StudOfGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudOfGroups()
    {
        return $this->hasMany(StudOfGroup::class, ['group_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['group_id' => 'id']);
    }

    public static function getGroupList()
    {
        if (Yii::$app->user->can('per_manager')){
            return static::find()->select(['title'])->indexBy('id')->where(['manager_id' => Yii::$app->user->id])->column();  
        } else {
            return static::find()->select(['title'])->indexBy('id')->column();  
        }
        
    }

    public function getManagerName()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

}
