<?php 

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\rssnews;

class MostRatedWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $mostRatedModel = new rssnews();
        $mostRatedModel = $mostRatedModel->mostRated();

        return $this->render('mostRatedWidget',['model' => $mostRatedModel]);
    }
}