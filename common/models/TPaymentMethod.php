<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_payment_method".
 *
 * @property int $id
 * @property string $method
 *
 * @property TBooking[] $tBookings
 */
class TPaymentMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_payment_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'method'], 'required'],
            [['id'], 'integer'],
            [['method'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => 'Method',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_payment_method' => 'id']);
    }
}
