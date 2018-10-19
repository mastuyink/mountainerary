<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_nationality".
 *
 * @property int $id
 * @property string $nationality
 *
 * @property TPassenger[] $tPassengers
 */
class TNationality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_nationality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nationality'], 'required'],
            [['nationality'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nationality' => 'Nationality',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_nationality' => 'id']);
    }

    public static function getNationality(){
        return static::find()->orderBy(['nationality'=>SORT_ASC])->asArray()->all();
    }
}
