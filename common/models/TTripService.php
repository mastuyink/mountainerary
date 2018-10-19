<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_trip_service".
 *
 * @property int $id
 * @property int $id_trip
 * @property int $id_service
 * @property int $type
 *
 * @property TService $service
 * @property TTrip $trip
 */
class TTripService extends \yii\db\ActiveRecord
{

    const TYPE_INCLUDE = true;
    const TYPE_EXCLUDE = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_trip_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_trip', 'id_service', 'type'], 'required'],
            [['id_trip', 'id_service', 'type'], 'integer'],
            [['id_service'], 'exist', 'skipOnError' => true, 'targetClass' => TService::className(), 'targetAttribute' => ['id_service' => 'id']],
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
            'id_service' => 'Id Service',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdService()
    {
        return $this->hasOne(TService::className(), ['id' => 'id_service']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }

    public static function checkTripServices($type,$id_trip,$services = []){
        if (is_array($services)) {
            foreach ($services as $key => $service) {
                $check   = static::find()->where(['AND',
                    ['id_service' => $service],
                    ['id_trip'    => $id_trip],
                    ['type'       => $type],
                ])->asArray()->one();
                if($check == null){
                    $counter             = count(static::find()->asArray()->all());
                    $newItem             = new TTripService();
                    $newItem->id         = $counter+1;
                    $newItem->id_trip    = $id_trip;
                    $newItem->id_service = $service;
                    $newItem->type       = $type;
                    $newItem->save(false);
                }
            }
        }

        return true;
        
    }
}
