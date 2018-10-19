<?php

namespace app\models;

use Yii;
use yii\base\Model;
use common\models\TTrip;
/**
 * ContactForm is the model behind the contact form.
 */
class BookingForm extends Model
{
	public $trip_date;
	public $adults;
	public $childs;
  public $id_trip;

	public function rules()
    {
        return [
           [['id_trip','trip_date','adults'],'required'],
           [['trip_date'],'date', 'format'=>'php:Y-m-d'],
           [['adults'],'integer','min'=>1],
           [['childs','id_trip'],'integer'],
           [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'trip_date' => 'Date Of Trip',
            'adults' => 'Adults',
            'childs' => 'childs',
        ];
    }
}