

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use app\models\PostRatingSearch;
use kartik\social\FacebookPlugin;
use app\models\PostSearch;


?>


<div class="col-sm-12">
    <?php 
        function cmp($a, $b) {
            if (strtotime($a['datetime']) == strtotime($b['datetime'])) {  return 0; }
            return (strtotime($a['datetime']) < strtotime($b['datetime'])) ? 1 : -1; 
        }
        uasort($models, 'cmp');
        $a = array();

    $output = "";
    $output .= "<div class='items_box'>";
    foreach ($models as $model) {     
            $output .= '<div class="item_style col-sm-12 col-md-5">';
            $output .= '<div class="item-box row">';
            $output .= '<div class="box-header">';
            $output .= $model['datetime'];
            $output .= '<div class="fb_like_btn"></div><div class="fb_share_btn"></div></div>';
            $output .= '<div class="box-body">';
            $output .= '<a href="#" url-redirect='. $model['main_link'] .' post='.$model['id'].'><h2>'. $model['title'] .'</h2></a>';
            $output .= '<p>' . $model->getContent($model['content']). '... <a href="'.$model['main_link'].'">Read more</a></p>';
             $output .= FacebookPlugin::widget(['type'=>FacebookPlugin::SHARE, 'settings' => ['size'=>'small', 'layout'=>'button_count', 'mobile_iframe'=>'false','href' => $model['main_link']]]);
            $output .= FacebookPlugin::widget(['type'=>FacebookPlugin::LIKE, 'settings' => ['size'=>'small','href' => $model['main_link']]]);

            $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="stars_style"> 
        <div id="'.$model['id'].'"class="rateyo-readonly-widg" data-preset="true" data-rating="'.$model->ratingFilter($model->rating).'"></div> 
                 </div>';
            $output .= '</div>';
    }
        $output .= "</div>";
        echo $output;
    ?>

<?php 
    $ttt = new PostSearch();

    $t = $ttt->getPostRating();

    echo "<pre>";

    print_r($t);




?>


</div>
<div class="col-sm-12">
    <div class>
        <?= LinkPager::widget([ 'pagination' => $pages, ]); ?>
    </div>
</div>
