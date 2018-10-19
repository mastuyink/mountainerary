<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_trip_unavailable".
 *
 * @property int $id
 * @property string $date_start
 * @property string $date_end
 * @property int $id_trip
 * @property string $created_at
 *
 * @property TTrip $trip
 */
class TTripUnavailable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_trip_unavailable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end', 'id_trip', 'created_at'], 'required'],
            [['date_start', 'date_end', 'created_at'], 'safe'],
            [['id_trip'], 'integer'],
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
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'id_trip' => 'Id Trip',
            'created_at' => 'Created At',
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
