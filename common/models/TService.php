<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_service".
 *
 * @property int $id
 * @property string $service
 *
 * @property TTripService[] $tTripServices
 */
class TService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service'], 'required'],
            [['service'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service' => 'Service',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTTripServices()
    {
        return $this->hasMany(TTripService::className(), ['id_service' => 'id']);
    }
}
