<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "t_pages".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $meta_description
 * @property string $content
 * @property string $datetime
 */
class TPages extends \yii\db\ActiveRecord
{
    const HOME_PAGE = 2;
    const ABOUT_US  = 1;
    public $keywords;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'meta_description', 'content'], 'required'],
            [['content'], 'string'],
            [['datetime','keywords'], 'safe'],
            [['title'], 'string', 'max' => 160],
            [['slug'], 'string', 'max' => 100],
            [['meta_description'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'meta_description' => 'Meta Description',
            'content' => 'Content',
            'datetime' => 'Datetime',
        ];
    }

    public function getUsedKeywords(){
        return $this->hasMany(TItemKeywords::className(), ['id_parent' => 'id'])->where(['t_item_keywords.id_item_type'=>TItemType::TYPE_PAGES]);
    }

    public function afterSave ($insert, $changedAttributes ){

        TItemKeywords::checkItemKeywords(TItemType::TYPE_PAGES,$this->id,$this->keywords);
    }
    
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $condition = ['AND',
            ['id_parent'=>$this->id],
            ['id_item_type'=>TItemType::TYPE_PAGES]
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

        return true;
    }
}
