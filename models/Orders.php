<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $order_key
 * @property int $client_id
 * @property float $cost
 * @property int $count
 * @property string $location
 * @property string $time
 * @property string $tel
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Cart[] $carts
 * @property Client $client
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];// TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_key', 'client_id', 'cost', 'count', 'location', 'status'], 'required'],
            [['client_id', 'count', 'status', 'created_at', 'updated_at'], 'integer'],
            [['cost'], 'number'],
            [['order_key', 'time', 'tel'], 'string', 'max' => 50],
            [['location'], 'string', 'max' => 100],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_key' => 'Order Key',
            'client_id' => 'Client ID',
            'cost' => 'Cost',
            'count' => 'Count',
            'location' => 'Location',
            'time' => 'Time',
            'tel' => 'Telephone',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}