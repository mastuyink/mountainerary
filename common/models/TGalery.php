<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_galery".
 *
 * @property int $id
 * @property int $id_item_type
 * @property int $id_parent
 * @property string $name
 * @property int $size
 * @property string $filename
 *
 * @property TItemType $itemType
 */
class TGalery extends \yii\db\ActiveRecord
{
    public $galeryFiles;
    public $returnUrl;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_galery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_type', 'id_parent', 'name', 'size', 'filename'], 'required'],
            [['galeryFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg','maxFiles'=>10],
            [['id_item_type', 'id_parent', 'size'], 'integer'],
            [['name', 'filename','returnUrl'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'size' => 'Size',
            'filename' => 'Filename',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdItemType()
    {
        return $this->hasOne(TItemType::className(), ['id' => 'id_item_type']);
    }
}
