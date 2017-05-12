<?php 

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\rssnews;

class RandomPostsWidget extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $randomPost = new rssnews();
        $dataRandom = array(
        'Strategy' => $randomPost->getRandom(9),
        'Arcade'   => $randomPost->getRandom(11),
        'Puzzles'  => $randomPost->getRandom(8)
        );

        return $this->render('RandomPostsWidget',['model' => $dataRandom]);
    }
}