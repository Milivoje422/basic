

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="col-sm-12">
    <h1 style="border-bottom: 2px solid black; padding-bottom:20px; margin-bottom: 20px;">
        <strong>
            <center>
                Politics
            </center>
        </strong>
    </h1>

</div>
<div class="col-sm-12">
    <?php 

        function cmp($a, $b) {
            if (strtotime($a['datetime']) == strtotime($b['datetime'])) {  return 0; }
            return (strtotime($a['datetime']) < strtotime($b['datetime'])) ? 1 : -1; 
        }
        uasort($models, 'cmp');
    $output = "";
    $output .= "<div class='items_box'>";
    foreach ($models as $model) {      
           $output .= '<div class="item_style col-sm-12 col-md-5">';
            $output .= '<div class="item-box row">';
             $output .= '<div class="box-header">';
                $output .= $model['datetime'];
             $output .= '<div class="fb_like_btn"></div><div class="fb_share_btn"></div></div>';
             $output .= '<div class="box-body">';
            $output .= '<a href='. $model['main_link'] .'><h2>'. $model['title'] .'</h2></a>';
                $output .= '<p>' . $model->getContent($model['content']). '... <a href="'.$model['main_link'].'">Read more</a></p>';
             $output .= '</div>';
            $output .= '</div>';
           $output .= '</div>';
    }
        $output .= "</div>";
        echo $output;
    ?>
</div>
<div class="col-sm-12">
    <div class>
        <?= LinkPager::widget([ 'pagination' => $pages, ]); ?>
    </div>
</div>

