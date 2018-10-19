<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_currency".
 *
 * @property string $currency
 * @property string $name
 * @property int $kurs
 * @property string $update_at
 *
 * @property TBooking[] $tBookings
 */
class TCurrency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency', 'name', 'kurs'], 'required'],
            [['kurs'], 'integer'],
            [['update_at'], 'safe'],
            [['currency'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 50],
            [['currency'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'currency' => 'Currency',
            'name' => 'Name',
            'kurs' => 'Kurs',
            'update_at' => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_currency' => 'currency']);
    }

    public static function getCurrency($currency){
        return TCurrency::find()->where(['currency'=>$currency])->asArray()->one();
    }
}
