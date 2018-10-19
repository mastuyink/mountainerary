<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "t_trip".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $id_category
 * @property string $meta_description
 * @property string $preview
 * @property string $content
 * @property int $price_min
 * @property int $price_pax
 * @property int $min_pax
 * @property string $thumbnail
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TBooking[] $tBookings
 * @property TCategory $category
 * @property TTripUnavailable[] $tTripUnavailables
 */
class TTrip extends \yii\db\ActiveRecord
{
    public $keywords;
    public $thumbnailFile;
    public $includes;
    public $excludes;
    const STATUS_ON = true;
    const STATUS_OFF = false;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_trip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'id_category', 'meta_description', 'preview', 'content', 'price_min', 'price_pax_adult','price_pax_child', 'min_pax', 'status'], 'required'],
            [['thumbnailFile'],'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['status'],'boolean'],
            [['id_category', 'price_min', 'price_pax_adult', 'min_pax','price_pax_child'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at','keywords','includes','excludes'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 70],
            [['meta_description'], 'string', 'max' => 160],
            [['preview'], 'string', 'max' => 250],
            [['thumbnail'], 'string'],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => TCategory::className(), 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'name'             => 'Name',
            'slug'             => 'Slug',
            'id_category'      => 'Category',
            'meta_description' => 'Meta Description',
            'preview'          => 'Preview',
            'keywords'         => 'Keywords',
            'content'          => 'Content',
            'price_min'        => 'Price Min',
            'price_pax_adult'  => 'Price Pax Adult',
            'price_pax_child'  => 'Price Pax Child',
            'min_pax'          => 'Min Pax',
            'thumbnail'        => 'Thumbnail',
            'status'           => 'Status',
            'created_at'       => 'Created At',
            'updated_at'       => 'Updated At',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_trip' => 'id']);
    }

    public function getTripTimelines()
    {
        return $this->hasMany(TTripTimeline::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategory()
    {
        return $this->hasOne(TCategory::className(), ['id' => 'id_category'])->where(['!=','t_category.id_item_type',TItemType::TYPE_BLOG]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTTripUnavailables()
    {
        return $this->hasMany(TTripUnavailable::className(), ['id_trip' => 'id']);
    }

    public function getUsedKeywords(){
        return $this->hasMany(TItemKeywords::className(), ['id_parent' => 'id'])->where(['t_item_keywords.id_item_type'=>TItemType::TYPE_TRIP]);
    }

    public function getGalerys(){
        return $this->hasMany(TGalery::className(), ['id_parent' => 'id'])->where(['t_galery.id_item_type'=>TItemType::TYPE_TRIP]);
    }

    public function getIncludeServices(){
        return $this->hasMany(TTripService::className(), ['id_trip' => 'id'])->where(['type'=>TTripService::TYPE_INCLUDE])->orderBy(['id_service'=>SORT_ASC]);
    }

    public function getExcludeServices(){
        return $this->hasMany(TTripService::className(), ['id_trip' => 'id'])->where(['type'=>TTripService::TYPE_EXCLUDE])->orderBy(['id_service'=>SORT_ASC]);
    }

    public static function getCategory(){
        return TCategory::find()->joinWith(['idItemType'])->where(['!=','t_category.id_item_type',TItemType::TYPE_BLOG])->asArray()->all();
    }

     public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $now = date('Y-m-d H:i:s');
        if ($this->isNewRecord) {
           $this->created_at = $now;
        }

        $this->updated_at = $now;
        
        return true;
    }

    public function afterSave ($insert, $changedAttributes ){

        TItemKeywords::checkItemKeywords(TItemType::TYPE_TRIP,$this->id,$this->keywords);
        TTripService::checkTripServices(TTripService::TYPE_INCLUDE,$this->id,$this->includes);
        TTripService::checkTripServices(TTripService::TYPE_EXCLUDE,$this->id,$this->excludes);
    }
    
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $condition = ['AND',
            ['id_parent'=>$this->id],
            ['id_item_type'=>TItemType::TYPE_TRIP]
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

    public function setService(){
        if (TTripService::find()->where(['id_trip'=>$this->id])) {
            # code...
        }
    }

    public function updateService($type){
        if ($type == 'includes') {
            $serviceRelation = $this->includeServices;
        }elseif ($type == 'excludes') {
            $serviceRelation = $this->excludeServices;
        }
        $oldService     = ArrayHelper::map($serviceRelation, 'id', 'id_service');
        $oldService     = is_array($oldService) ? $oldService : [];
        $deletedService = array_diff($oldService, $this->$type);

        if (!empty($deletedService)) {
            $condition[]        = "OR";
            foreach ($deletedService as $key => $value) {
                $condition[] = ['id'=>$key];
            }
            TTripService::deleteAll($condition);
        }
    }

    public function updateTimelines($submitedTimelines){
        $oldTimnelines  = ArrayHelper::map($this->tripTimelines, 'id', 'id');
        $oldTimnelines  = is_array($oldTimnelines) ? $oldTimnelines : [];
        $deletedTimelines = array_diff($oldTimnelines, $submitedTimelines);

        if (!empty($deletedTimelines)) {
            $condition[]        = "OR";
            foreach ($deletedTimelines as $key => $value) {
                $condition[] = ['id'=>$key];
            }
            TTripTimeline::deleteAll($condition);
        }
    }
}
 