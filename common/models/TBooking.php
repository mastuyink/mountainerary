<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_booking".
 *
 * @property string $id
 * @property int $id_trip
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $token
 * @property int $id_status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TTrip $trip
 * @property TPassenger[] $tPassengers
 */
class TBooking extends \yii\db\ActiveRecord
{
    const STATUS_UNPAID  = 1;
    const STATUS_PAID    = 2;
    const STATUS_CONFIRM = 3;
    const STATUS_SUCCESS = 4;
    const STATUS_CANCEL  = 5;
    const STATUS_REFUND  = 6;

    const PAYMENT_POD    = 1;
    const PAYMENT_PAYPAL = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_trip', 'name', 'email', 'phone', 'token', 'id_status', 'created_at', 'updated_at','trip_date','id_currency'], 'required'],
            [['id_trip', 'id_status','amount','id_payment_method'], 'integer'],
            [['created_at', 'updated_at','amount_idr'], 'safe'],
            [['id'], 'string', 'max' => 5],
            [['id_currency'], 'string', 'max' => 3],
            [['name', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 25],
            [['token'], 'string', 'max' => 10],
            [['token'], 'unique'],
            [['id'], 'unique'],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
            [['id_payment_method'], 'exist', 'skipOnError' => true, 'targetClass' => TPaymentMethod::className(), 'targetAttribute' => ['id_payment_method' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Code',
            'id_trip' => 'Id Trip',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'token' => 'Token',
            'id_payment_method' => 'Payment Method',
            'id_status' => 'Id Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }

    public function getIdPaymentMethod()
    {
        return $this->hasOne(TPaymentMethod::className(), ['id' => 'id_payment_method']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->orderBy(['t_passenger.type'=>SORT_ASC]);
    }

    public function getAdultPassengers(){
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['t_passenger.type'=>TPassenger::TYPE_ADULT]);
    }

    public function getChildPassengers(){
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['t_passenger.type'=>TPassenger::TYPE_CHILD]);
    }

    public function getShuttles(){
        return $this->hasMany(TShuttle::className(), ['id_booking' => 'id'])->orderBy(['t_shuttle.type'=>SORT_DESC]);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $now = date('Y-m-d H:i:s');
        if ($this->isNewRecord) {
           $this->created_at = $now;
        }

        $this->updated_at = $now;
        
        return true;
    }
}
