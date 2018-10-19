<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_item_keywords".
 *
 * @property int $id
 * @property int $id_item_type
 * @property int $id_parent
 * @property int $id_keyword
 *
 * @property TKeywords $keyword
 * @property TItemType $itemType
 */
class TItemKeywords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_item_keywords';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_type', 'id_parent', 'id_keyword'], 'required'],
            [['id_item_type', 'id_parent', 'id_keyword'], 'integer'],
            [['id_keyword'], 'exist', 'skipOnError' => true, 'targetClass' => TKeywords::className(), 'targetAttribute' => ['id_keyword' => 'id']],
            [['id_item_type'], 'exist', 'skipOnError' => true, 'targetClass' => TItemType::className(), 'targetAttribute' => ['id_item_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_item_type' => 'Id Item Type',
            'id_parent' => 'Id Parent',
            'id_keyword' => 'Id Keyword',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKeyword()
    {
        return $this->hasOne(TKeywords::className(), ['id' => 'id_keyword']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemType()
    {
        return $this->hasOne(TItemType::className(), ['id' => 'id_item_type']);
    }

    public static function checkItemKeywords($type,$parent,$keywords = []){
        if (is_array($keywords)) {
            foreach ($keywords as $key => $value) {
                $keyword = TKeywords::checkKeyword($value);
                $check   = TItemKeywords::find()->where(['AND',
                    ['id_item_type' => $type],
                    ['id_keyword'   => $keyword],
                    ['id_parent'    => $parent]
                ])->asArray()->one();
                if($check == null){
                    //$counter               = count(static::find()->asArray()->all());
                    $newItem               = new TItemKeywords();
                    //$newItem->id           = $counter+1;
                    $newItem->id_item_type = $type;
                    $newItem->id_parent    = $parent;
                    $newItem->id_keyword   = $keyword;
                    $newItem->save(false);
                }
            }
        }

        return true;
        
    }
}
