<?php

namespace app\models;

use Yii;
use app\models\PostVisitors;
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

    public function getRating(){
        return $this->hasMany(PostRatingSearch::className(), ['post_id' => 'id']);
    }

    public function getVisitors(){
        return $this->hasMany(PostVisitors::className(), ['post_id' => 'id']);
    }     

     public function getContent($content)
    {
      $content_text = preg_replace("/<img[^>]+\>/i", " ", $content);
        return  substr($content_text, 0, 200);
    }
    
    public function get_img($content)
    {
        preg_match('/<img[^>]+\>/i',$content, $matches1);
        foreach ($matches1 as $value) {
            return $value;    
        }
    }

    public function ratingFilter($getRating)
    {
        $ratings = array();
        foreach ($getRating as $key => $value) {
            $ratings[] = $value['raiting_value'];
        }

        if(array_sum($ratings) !== 0){
            $totalRating = array_sum($ratings) / count($ratings);
        }else
        {
            $totalRating = 0;
        }

        if($totalRating >= 5)
            $totalRating = 5;

        return $totalRating;
    }

}
