<?php

namespace app\models;

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
 * @property string $currency
 * @property int $id_status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TTrip $trip
 * @property TPassenger[] $tPassengers
 */
class Reservation extends \common\models\TBooking
{

    public $pickup;
    public $pickupArea;
    public $pickupDescription;
    public $dropOff;
    public $dropOffArea;
    public $dropOffDescription;

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
            [['id_trip', 'name', 'email', 'phone','trip_date'], 'required'],
            [['name', 'email'], 'string', 'max' => 100],
            [['trip_date'],'date', 'format'=>'php:Y-m-d'],
            [['email'],'email'],
            [['pickup','dropOff'],'boolean'],
            [['pickupDescription','dropOffDescription'],'string'],
            [['phone'], 'string', 'max' => 25],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
            [['pickupArea'], 'required','when'=> function ($model) {
            return $model->pickup == true;
            }, 'whenClient' => "function (attribute, value) {
            return $('#checkbox-pickup').is(':checked');
            }"],
            [['dropOffArea'], 'required','when'=> function ($model) {
            return $model->dropOff == true;
            }, 'whenClient' => "function (attribute, value) {
            return $('#checkbox-drop').is(':checked');
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'id_trip'            => 'Id Trip',
            'name'               => 'Name',
            'email'              => 'Email',
            'phone'              => 'Phone',
            'pickup'             => 'Required Pickup',
            'dropOff'            => 'Required Drop Off',
            'pickupArea'         => 'Pickup Area',
            'dropOffArea'        => 'Drop Off Area',
            'pickupDescription'  => 'Address',
            'dropOffDescription' => 'Address',

        ];
    }

    public function getTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }

    public function getIdCurrency()
    {
        return $this->hasOne(TCurrency::className(), ['currency' => 'id_currency']);
    }

    public function generateCode($attribute, $length){
        $pool = array_merge(range(0,9),range('A', 'Z')); 
        for($i=0; $i < $length; $i++) {
            $key[] = $pool[mt_rand(0, count($pool) - 1)];
        }
        // if ($type == '2') {
             //   $kodeBooking = "G".join($key)."Y";
           // }else{
                $kodeBooking = join($key);
           // }          
         
        if(!$this->findOne([$attribute => $kodeBooking])) {
            return $kodeBooking;
        }else{
            return $this->generateBookingNumber($attribute,$length);
        }
                
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
