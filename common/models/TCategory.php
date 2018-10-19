<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "t_category".
 *
 * @property int $id
 * @property int $id_item_type
 * @property string $category
 * @property string $meta_description
 *
 * @property TBlog[] $tBlogs
 * @property TItemType $itemType
 * @property TTrip[] $tTrips
 */
class TCategory extends \yii\db\ActiveRecord
{
    public $keywords;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_type', 'category', 'meta_description','slug'], 'required'],
            [['id_item_type'], 'integer'],
            [['keywords'],'safe'],
            [['category','slug'], 'string', 'max' => 50],
            [['meta_description'], 'string', 'max' => 170],
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
            'id_item_type' => 'Item Type',
            'category' => 'Category Name',
            'meta_description' => 'Meta Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBlogs()
    {
        return $this->hasMany(TBlog::className(), ['id_category' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdItemType()
    {
        return $this->hasOne(TItemType::className(), ['id' => 'id_item_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTTrips()
    {
        return $this->hasMany(TTrip::className(), ['id_category' => 'id']);
    }

    public function getUsedKeywords(){
        return $this->hasMany(TItemKeywords::className(), ['id_parent' => 'id'])->where(['id_item_type'=>TItemType::TYPE_CATEGORY]);
    }


    //CUSTOM SCRIPT

    public static function getItemType(){
        return TItemType::find()->asArray()->all();
    }

    public function afterSave ($insert, $changedAttributes ){

        TItemKeywords::checkItemKeywords(TItemType::TYPE_CATEGORY,$this->id,$this->keywords);
    }
    
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $condition = ['AND',
            ['id_parent'=>$this->id],
            ['id_item_type'=>TItemType::TYPE_CATEGORY]
        ];
        TItemKeywords::deleteAll($condition);
        return true;
    }


    public function getKeywords(){
            $listKeywords = ArrayHelper::map(TKeywords::getAllKeywords(), 'keyword', 'keyword');
        // if (!$this->isNewRecord) {
        //     $this->keywords = ArrayHelper::map($this->usedKeywords, 'id_keyword', 'idKeyword.keyword');
        // }
        return $listKeywords;
    }

    public function setKeywords(){
        //if (!$this->isNewRecord) {
            $oldKeyword         = ArrayHelper::map($this->usedKeywords, 'id', 'idKeyword.keyword');
            $oldKeyword         = is_array($oldKeyword) ? $oldKeyword : [];
            $deletedPageKeyword = array_diff($oldKeyword, $this->keywords);

            if (!empty($deletedPageKeyword)) {
                $condition[]        = "OR";
                foreach ($deletedPageKeyword as $key => $value) {
                    $condition[] = ['id'=>$key];
                }
                TItemKeywords::deleteAll($condition);
            }
       // }

        return true;
    }
}
