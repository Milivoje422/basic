<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rssnews".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $content
 * @property string $datetime
 * @property string $raiting
 * @property string $preview
 * @property string $main_link
 */
class Rssnews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rssnews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'content', 'datetime', 'image', 'main_link'], 'required'],
            [['category_id'], 'integer'],
            [['datetime'], 'safe'],
            [['content'], 'string', 'max' => 5000],
            [['title', 'raiting', 'main_link', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app','ID'),
            'category_id'   => Yii::t('app','Category ID'),
            'title'         => Yii::t('app','Title'),
            'content'       => Yii::t('app','Content'),
            'datetime'      => Yii::t('app','Datetime'),
            'raiting'       => Yii::t('app','Raiting'),
            'image'         => Yii::t('app','Image'),
            'main_link'     => Yii::t('app','Main Link'),
        ];
    }

    public function getPostRating()
    {
        return $this->hasMany(PostRating::className(), ['post_id' => 'id']);
    }

    public function getPostVisitors()
    {
        return $this->hasMany(PostVisitors::className(), ['post_id' => 'id']);
    }



}
