<?php 

namespace app\widgets;

use yii\base\Widget;
use app\models\Posts;

class MostPlayedWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $mostPlayedModel = new Posts();
        $mostPlayedModel = $mostPlayedModel->mostPlayed();

        return $this->render('MostPlayedWidget',['model' => $mostPlayedModel]);
    }
}