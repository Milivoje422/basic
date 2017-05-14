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
use app\models\rssnews;

class RecommendedGamesWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $recommendedModel = new rssnews();
        $recommendedModel = $recommendedModel->recommendedLogic();

        return $this->render('RecommendedGamesWidget',['model' => $recommendedModel]);
    }
}