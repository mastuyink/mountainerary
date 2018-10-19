<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_passenger".
 *
 * @property int $id
 * @property string $id_booking
 * @property string $name
 * @property int $id_nationality
 * @property string $birthday
 * @property int $type
 * @property string $datetime
 *
 * @property TNationality $nationality
 * @property TBooking $booking
 */
class TPassenger extends \yii\db\ActiveRecord
{

    const TYPE_ADULT  = 1;
    const TYPE_CHILD  = 2;
    const TYPE_INFANT = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_passenger';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_nationality'], 'required'],
            [['id_nationality', 'type'], 'integer'],
            [['birthday', 'datetime'], 'safe'],
            [['id_booking'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 100],
            [['id_nationality'], 'exist', 'skipOnError' => true, 'targetClass' => TNationality::className(), 'targetAttribute' => ['id_nationality' => 'id']],
            [['id_booking'], 'exist', 'skipOnError' => true, 'targetClass' => TBooking::className(), 'targetAttribute' => ['id_booking' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_booking' => 'Id Booking',
            'name' => 'Name',
            'id_nationality' => 'Nationality',
            'birthday' => 'Birthday',
            'type' => 'Type',
            'datetime' => 'Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNationality()
    {
        return $this->hasOne(TNationality::className(), ['id' => 'id_nationality']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(TBooking::className(), ['id' => 'id_booking']);
    }

    public function getPassengerType(){
        if ($this->type == self::TYPE_ADULT) {
            return 'Adult';
        }elseif ($this->type == self::TYPE_CHILD) {
            return 'Child';
        }elseif ($this->type == self::TYPE_INFANT) {
            return 'Infant';
        }
    }

    public static function addPassenger(array $data){
        $savePassenger                 = new TPassenger();
        $savePassenger->id_booking     = $data['id_booking'];
        $savePassenger->name           = $data['name'];
        $savePassenger->id_nationality = $data['id_nationality'];
        $savePassenger->birthday       = $data['birthday'];
        $savePassenger->type        = $data['type'];
        $savePassenger->validate();
        $savePassenger->save(false); 
    }
}
