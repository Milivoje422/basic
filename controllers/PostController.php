<?php



namespace app\controllers;

use yii\rest\ActiveController;
use app\models\ApiVisitors;

class PostController extends ActiveController{

    public $modelClass = 'app\models\rssnews';

    public function init()
    {
        parent::init();
        $model = new ApiVisitors();
        $model = $model->findByIp($_SERVER['REMOTE_ADDR']);

            if(!empty($model->attributes['user_ip'])){
                if($model->status == "active"){
                    if ($model->attributes['datetime'] < $model->attributes['last_get']){
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
                $model->user_ip = $_SERVER['REMOTE_ADDR'];
                $model->visited = 1;
                $model->status = 'active';
                $model->datetime = date('Y-m-d');
                $model->last_get = date('Y-m-d');
                $model->save();
            }
    }

//    public function actionIndex(){
//        $model = ApiVisitors::find()
//            ->limit($_GET['limit'])
//            ->all();
//        return $model;
//    }

//    public function actionView($id)
//    {
//        return ApiVisitors::findOne($id);
//    }


}
