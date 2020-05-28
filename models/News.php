<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property string $img
 * @property int $start
 * @property int $end
 * @property int $status
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img', 'start', 'end', 'text'], 'safe'],
//            [['start', 'end', 'status'], 'integer'],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img' => 'Изображение',
            'start' => 'Начало',
            'end' => 'Окончание',
            'status' => 'Статус',
            'text' => 'Текст',
        ];
    }
}
