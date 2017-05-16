

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use kartik\social\FacebookPlugin;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="col-sm-12 main_box_layout">
    <div class="cat_name">
        <?= Yii::t('app',"Search Games") ?>
    </div>
    <?php
    $array = array();
    $output = "";
    foreach ($models as $model) {
        $output .= '<div class="col-sm-12 col-xs-12">';
        $output .= '<div class="item-box">';

        // image section 
        $output .= '<div class="box-left">';
        $output .= '<img src="'.$model['image'].'" class="post_img_class"/>';
        $output .= '</div>';


        // Text section 
        $output .= '<div class="box-center">';
        $output .= '<h3><a href="#" url-redirect='.$model['main_link'].' post='.$model['id'].'>'. $model['title'] .'</a></h3>';
        $output .= '<p>'.$model->getContent($model['content']).'...</p>';
        $output .= '</div>';


        // Links section
        $output .= '<div class="box-right">';
        $output .=
            '<div class="button_play_box">
            <a href="#" class="btn btn-warning button_play" role="button">'.Yii::t('app','Play now').'
            <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
            </a>
        </div>';
        $output .= '<div class="box-review"><span class="glyphicon glyphicon-eye-open"></span>  '. count($model->visitors).'</div>';

        $output .= '<div class="stars_style"> 
        <div id="'.$model['id'].'"class="rateyo-readonly-widg" data-preset="true" data-rating="'.$model->ratingFilter($model['rating']).'"></div></div>';

        $output .= "<div class='social-media-btns'>".
            FacebookPlugin::widget(['type'=>
                FacebookPlugin::LIKE, 'settings' =>
                ['size'=>'small',"data-layout"=>"button",
                    'href' => $model['main_link']]]);

        $output .=
            FacebookPlugin::widget(['type'=>
                FacebookPlugin::SHARE, 'settings' =>
                ['size'=>'small', 'layout'=>'button_count',
                    'mobile_iframe'=>'false','href' => $model['main_link']]]);
        $output .= "</div>";
        $output .= '</div>';


        $output .= '</div>';
        $output .= '</div>';
    }
    echo $output;
    ?>
</div>
<div class="col-sm-12">
    <div class>
        <?= LinkPager::widget([ 'pagination' => $pages, ]); ?>
    </div>
</div>

