<?php 

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\rssnews;

class MostPlayedWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $mostPlayedModel = new rssnews();
        $mostPlayedModel = $mostPlayedModel->mostPlayed();

        return $this->render('mostPlayedWidget',['model' => $mostPlayedModel]);
    }
}