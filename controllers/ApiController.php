<?php



namespace app\controllers;

use app\models\PostRating;
use app\models\PostVisitors;
use app\models\rssnews;
use yii\rest\ActiveController;
use app\models\ApiVisitors;

class ApiController extends ActiveController{

    public $modelClass = 'app\models\PostRating';


    /**
     * Behavior for the JSON response
     */
//    public function behaviors()
//    {
//        return [
//            [
//                'class' => \yii\filters\ContentNegotiator::className(),
//                'only' => ['index', 'view'],
//                'formats' => [
//                    'application/json' => \yii\web\Response::FORMAT_JSON,
//                ],
//            ],
//        ];
//    }


    /**
     *
     * Logic for users who visit rest api and get data from him.
     * Save user ip, if there no that user in db. $key is user ip address.
     * If user ip is blocked stop him here and If the user has already downloaded 100 times API stop him here
     *
     * */
    public function init()
    {
        parent::init();
        $model = new ApiVisitors();
        $model = $model->findByIp($_SERVER['REMOTE_ADDR']);

            if(!empty($model->attributes['user_ip'])){
                if($model->status == "active"){
                    if ($model->attributes['datetime'] < $model->attributes['last_get']){
                        $model->datetime = date('Y-m-d');
                        $model->visited = 1;
                    }elseif($model->attributes['datetime'] == $model->attributes['last_get']) {
                        if ($model->visited == 100) {
                            die('You are not able to get data today any more, try tomorrow again if fails again, then contact Admin!');
                        };
                        $model->visited += 1;
                    };
                    $model->last_get = date('Y-m-d');
                    $model->save();
                }else{
                    die('You are not able to get data! You are blocked!');
                }
            }else{
                $visitor = new ApiVisitors();
                $visitor->user_ip = $_SERVER['REMOTE_ADDR'];
                $visitor->visited = 1;
                $visitor->status = 'active';
                $visitor->datetime = date('Y-m-d');
                $visitor->last_get = date('Y-m-d');
                $visitor->save();
            }
    }


    /**
     * Acton for Rating if there is category id ,
     * then gets rating for posts only from specific category
     * if not then gets all vating in last 30 days
     */
    public function actionRating($category = null){
        if(!empty($category)) {
           $query = "SELECT * FROM post_rating
            INNER JOIN posts ON post_rating.post_id=posts.id
            WHERE created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            AND posts.category_id = $category
            ORDER BY post_rating.post_id DESC";
        }else{
            $query = "SELECT * FROM post_rating
            WHERE created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            ORDER BY created_at DESC";
        }
        $return = PostRating::findBySQL($query)->all();
        return $return;
    }


    /*
     * Acton for Visitors if there is category id ,
     * then gets visitors for posts only from specific category
     * if not then gets all visitors in last 30 days
     * */
    public function actionVisitors($category = null){
        if(!empty($category)) {
            $query = "SELECT * FROM post_visitors
            INNER JOIN posts ON post_visitors.post_id=posts.id
            WHERE created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            AND posts.category_id = $category
            ORDER BY post_visitors.post_id DESC";
        }else{
            $query = "SELECT * FROM post_visitors
            WHERE created_at BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()
            ORDER BY created_at DESC";
        }
        $return = PostVisitors::findBySQL($query)->all();
        return $return;
    }

}
