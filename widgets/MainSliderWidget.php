<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Posts;

class MainSliderWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $mostPlayedModel = new Posts();
        $mostPlayedModel = array_merge(
            $mostPlayedModel->getRandom(rand(1,11),10),
            $mostPlayedModel->getRandom(rand(1,11),10),
            $mostPlayedModel->getRandom(rand(1,11),10)
        );


        return $this->render('MainSliderWidget',['model' => $mostPlayedModel]);
    }
}