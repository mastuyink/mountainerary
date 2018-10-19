<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_trip_timeline".
 *
 * @property int $id
 * @property int $id_trip
 * @property string $name
 * @property int $duration
 * @property string $time_start
 * @property string $time_end
 *
 * @property TTrip $trip
 */
class TTripTimeline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_trip_timeline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'duration', 'time_start', 'time_end'], 'required'],
            [['id_trip', 'duration'], 'integer'],
            [['time_start', 'time_end'], 'safe'],
            [['name'], 'string', 'max' => 250],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_trip' => 'Id Trip',
            'name' => 'Name',
            'duration' => 'Day',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }
}
