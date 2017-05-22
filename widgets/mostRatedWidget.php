<?php 

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Posts;

class MostRatedWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $mostRatedModel = new Posts();
        $mostRatedModel = $mostRatedModel->mostRated();

        return $this->render('MostRatedWidget',['model' => $mostRatedModel]);
    }
}