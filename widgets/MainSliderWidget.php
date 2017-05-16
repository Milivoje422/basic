<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\rssnews;

class MainSliderWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $mostPlayedModel = new rssnews();
        $mostPlayedModel = $mostPlayedModel->mostPlayed();

        return $this->render('MainSliderWidget',['model' => $mostPlayedModel]);
    }
}