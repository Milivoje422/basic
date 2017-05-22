<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 5/13/2017
 * Time: 1:23 PM
 */


namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Posts;
use app\models\PostVisitors;
use yii\web\Cookie;
use Yii;

class RecommendedGamesWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = new PostVisitors();
        $posts = new Posts();
        $model = $model->getAll();
        if(count($model) >= 10){

            $posts = $posts->recommendedLogic();
            $cats = array();
            $post = array();

            foreach($posts as $key => $val){
                $cats[] = $val['category_id'];
                $post[] = $val['id'];
            }

            $post = array_unique($post);
            $cats = array_unique($cats);

            $c = implode(",",$cats);
            $p = implode(",",$post);

            $query = "SELECT * FROM posts WHERE category_id IN ({$c}) AND id NOT IN ({$p}) ORDER BY RAND() LIMIT 20 ";

            $return = Posts::findBySQL($query)->all();

            return $this->render('RecommendedGamesWidget',['model' => $return]);
        }
    }
}