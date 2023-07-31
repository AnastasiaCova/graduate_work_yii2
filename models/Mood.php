<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mood".
 *
 * @property int $id
 * @property string $title
 * @property string $image
 *
 * @property Reflection[] $reflections
 */
class Mood extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mood';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'image'], 'required'],
            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Настроение',
            'image' => 'Изображение',
        ];
    }

    /**
     * Gets query for [[Reflections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReflections()
    {
        return $this->hasMany(Reflection::class, ['mood_id' => 'id']);
    }

    public static function getMoodList()
    {
        return static::find()->select(['title'])->indexBy('id')->column();  
    }
}
