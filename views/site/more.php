<?php
use app\widgets\MainSliderWidget;
?>

<div class="widgets_index">
    <div class="widget_ col-sm-12">
        <div class="row">
            <?= MainSliderWidget::widget() ?>
        </div>
    </div>
</div>
<div class="col-sm-12 more_box_layout">
    <div class="cat_name">
        <?= Yii::t('app','MORE games'); ?>
    </div>
    <div class='more_box'>
<?php foreach($model as $key => $val){
$output = "";

$output .= "<div class='cat_box'>";
$output .= "<h3>".$val['name']."</h3></br>";
$output .= "<p>games</p>";


$output .= "</div>";

echo $output;
} ?>
	</div>
</div>