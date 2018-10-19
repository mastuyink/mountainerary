<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "t_shuttle_area".
 *
 * @property int $id
 * @property string $area
 * @property int $default_price
 *
 * @property TShuttle[] $tShuttles
 */
class TShuttleArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_shuttle_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area', 'default_price'], 'required'],
            [['default_price'], 'integer'],
            [['area'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => 'Area',
            'default_price' => 'Default Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttles()
    {
        return $this->hasMany(TShuttle::className(), ['id_area' => 'id']);
    }

    public static function getShuttleArea($condition = [],$map = true){
        $model = static::find();
        if (!empty($condition)) {
            $model->where($condition);
        }

        $result = $model->orderBy(['area'=>SORT_ASC])->asArray()->all();
        if ($map = true) {
            foreach ($result as $key => $value) {
                if ($value['default_price'] > 0){
                    $price = 'IDR '.number_format($value['default_price'],0);
                }else{
                    $price = 'Free';
                }
                $arrays[] = ['id'=>$value['id'],'area'=>$value['area'].' ('.$price.')','price'=>$value['default_price']];
            }
            $result = ArrayHelper::map($arrays, 'id', 'area');
        }

        return $result;
    }
}
