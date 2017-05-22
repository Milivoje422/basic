<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "posts".
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
class Posts extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
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
            [['title', 'rating', 'main_link', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     *
     * Class attributes
     *
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

        /* ======== Relation ======== */

    public function getRating(){
        return $this->hasMany(PostRating::className(), ['post_id' => 'id']);
    }

    public function getVisitors(){
        return $this->hasMany(PostVisitors::className(), ['post_id' => 'id']);
    }

          /* ======== End ======== */


    /**
     * Get content , remove img tags from content and get me only 200 characters
     *
     */
    public function getContent($content, $num = 200)
    {
      $content_text = preg_replace("/<img[^>]+\>/i", " ", $content);
        return  substr($content_text, 0, $num);
    }

    /**
     * Get img from content / method is not in use right now
     */
    public function get_img($content)
    {
        preg_match('/<img[^>]+\>/i',$content, $matches1);
        foreach ($matches1 as $value) {
            return $value;    
        }
    }

    /**
     * Get all rating from array parameter and calculate into one result
     */
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

    /**
     * Category query method / depends on category id
     *
     * @return $query
     */
    public function categorySearch($id)
    {
        // Get posts and sort them according on reviews by ID
        $query = Posts::find()
        ->select(['posts.*', 'COUNT(post_visitors.post_id) AS countVisit'])
        ->where(["category_id" => $id])
        ->joinWith('visitors')
        ->joinWith('rating')
        ->groupBy(['posts.id'])
        ->orderBy(['countVisit' => SORT_DESC]);

        return $query;
    }


    /**
     * MostPlayed games query method
     * return games depends by mysql query
     *
     * @return $query
     */
    public function mostPlayed()
    {
        // Get posts and sort them according on reviews
        $query = Posts::find()
        ->select(['posts.*', 'COUNT(post_visitors.post_id) AS countVisit'])
        ->joinWith('visitors')
        ->limit(22)
        ->groupBy(['posts.id'])
        ->orderBy(['countVisit' => SORT_DESC])
        ->all();

        return $query;
    }


    /**
     * MostRated games query method
     * return games depends by mysql query
     *
     * @return $query
     */
    public function mostRated()
    {
        // Get posts and sort them according on rating
        $query = Posts::find()
        ->select(['posts.*','SUM(post_rating.raiting_value) / COUNT(post_rating.raiting_value) AS countRated'])
        ->joinWith('rating')
        ->limit(7)
        ->groupBy(['posts.id'])
        ->orderBy(['countRated' => SORT_DESC])
        ->all();

        return $query;
    }


    /**
     * Get random games depends on @id for which category
     * Rest logic finished in controller / here only a query
     *
     * @return $query
     */
    public function getRandom($id,$limit = 3)
    {
        // Get random post for specific id  
        $query = Posts::find()->where(["category_id" => $id])->limit($limit)->orderBy(['rand()'=>SORT_DESC])->all();

        return $query;
    }


     /* @return array|\yii\db\ActiveRecord[]
     *
     * Recommended method query, which gets post ID and category ID for us.
     *
     */
    public function recommendedLogic()
    {
        $query = "SELECT posts.id, posts.category_id FROM post_visitors
        INNER JOIN posts ON post_visitors.post_id=posts.id
        ORDER BY post_visitors.post_id DESC
        LIMIT 10";

        $return = Posts::findBySQL($query)->all();
        return $return;
    }


    /**
     * Global search query
     * If there is no query then return all posts query sorted by best rating
     *
     * Search for games which looking for game Title and content
     * return query depends by request
     * Rest logic finished in controller
     *
     * @return $query
     */
    public function Search($query){

        $model = Posts::find()
            ->select(['posts.*','SUM(post_rating.raiting_value) / COUNT(post_rating.raiting_value) AS countRated'])
            ->joinWith('rating')
            ->groupBy(['posts.id'])
            ->orderBy(['countRated' => SORT_DESC]);

        if(!empty($query)){
            $model = Posts::find();

            $model->andFilterWhere(['like', 'title', $query])
                  ->andFilterWhere(['like', 'content', $query]);
        }

        return $model;
    }

}
