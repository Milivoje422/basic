

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
                Latest news
            </center>
        </strong>
    </h1>

</div>
<div class="col-sm-12">
    <?php 
$output = "";
foreach ($models as $model) {
       $output .= '<div class="item_style col-sm-6">';
        $output .= '<div class="item-box row">';
         $output .= '<div class="box-header">';
            $output .= $model['datetime'];
         $output .= '</div>';
         $output .= '<div class="box-body">';
            $output .= '<h2>'. $model['title'] .'</h2>'; 
            $output .= '<p>' . $model['content'] . '</p>';
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

