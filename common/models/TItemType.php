<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_item_type".
 *
 * @property int $id
 * @property string $type
 *
 * @property TCategory[] $tCategories
 * @property TGalery[] $tGaleries
 * @property TItemKeywords[] $tItemKeywords
 */
class TItemType extends \yii\db\ActiveRecord
{
    const TYPE_TRIP     = 1;
    const TYPE_BLOG     = 2;
    const TYPE_ALL      = 3;
    const TYPE_CATEGORY = 4;
    const TYPE_PAGES = 5;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_item_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'required'],
            [['id'], 'integer'],
            [['type'], 'string', 'max' => 25],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTCategories()
    {
        return $this->hasMany(TCategory::className(), ['id_item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTGaleries()
    {
        return $this->hasMany(TGalery::className(), ['id_item_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTItemKeywords()
    {
        return $this->hasMany(TItemKeywords::className(), ['id_item_type' => 'id']);
    }
}
