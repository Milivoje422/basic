<?php



namespace app\controllers;


use yii\rest\ActiveController;
use app\models\ApiVisitors;

class RestController extends ActiveController{

    public $modelClass = 'app\models\rssnews';

    public function init()
    {
//        parent::init();
//        $model = new ApiVisitors();
//        $model->findByIp($_SERVER['REMOTE_ADDR']);






        die('You are not able to get api data!');
    }
}
