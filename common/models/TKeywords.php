<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_keywords".
 *
 * @property int $id
 * @property string $keyword
 *
 * @property TItemKeywords[] $tItemKeywords
 */
class TKeywords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_keywords';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keyword'], 'required'],
            [['keyword'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keyword' => 'Keyword',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTItemKeywords()
    {
        return $this->hasMany(TItemKeywords::className(), ['id_keyword' => 'id']);
    }

    public static function getAllKeywords(){
        return static::find()->asArray()->all();
    }

    public static function checkKeyword($input){
        $keyword = static::findOne(['keyword'=>$input]);
        if ($keyword == null) {
            $counter          = count(static::find()->asArray()->all());
            $keyword          = new TKeywords();
            $keyword->id      = $counter+1;
            $keyword->keyword = $input;
            $keyword->save(false);
        }

        return $keyword->id;
    }
}
