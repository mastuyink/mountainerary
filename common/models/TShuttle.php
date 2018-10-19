<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle".
 *
 * @property int $id
 * @property string $id_booking
 * @property int $id_area
 * @property string $description
 *
 * @property TShuttleArea $area
 * @property TBooking $booking
 */
class TShuttle extends \yii\db\ActiveRecord
{
    const TYPE_PICKUP = true;
    const TYPE_DROP_OFF = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_shuttle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_booking', 'id_area', 'description','type'], 'required'],
            [['id_area'], 'integer'],
            [['description'], 'string'],
            [['type'],'boolean'],
            [['id_booking'], 'string', 'max' => 5],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleArea::className(), 'targetAttribute' => ['id_area' => 'id']],
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
            'id_area' => 'Id Area',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(TShuttleArea::className(), ['id' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(TBooking::className(), ['id' => 'id_booking']);
    }

    public function getShutleType(){
        if ($this->type == self::TYPE_PICKUP) {
            return 'Pickup';
        }else{
            return 'Drop Off';
        }
    }

    public static function addShuttle($data = []){
        $model              = new TShuttle();
        $model->id_booking  = $data['id_booking'];
        $model->id_area     = $data['id_area'];
        $model->description = $data['description'];
        $model->type        = $data['type'];
        $model->price       = $model->idArea->default_price;
        $model->save(false);
        return $model->price;
    }
}

