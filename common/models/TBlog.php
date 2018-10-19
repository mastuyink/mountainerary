<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_blog".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $meta_description
 * @property int $id_category
 * @property string $content
 * @property string $thumbnail
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TCategory $category
 */
class TBlog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'meta_description', 'id_category', 'content', 'thumbnail', 'created_at', 'updated_at'], 'required'],
            [['id_category'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 70],
            [['meta_description'], 'string', 'max' => 170],
            [['thumbnail'], 'string', 'max' => 100],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => TCategory::className(), 'targetAttribute' => ['id_category' => 'id']],
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
            'id_category' => 'Id Category',
            'content' => 'Content',
            'thumbnail' => 'Thumbnail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TCategory::className(), ['id' => 'id_category']);
    }
}
