<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 5/13/2017
 * Time: 1:23 PM
 */
?>


<div class="col-sm-12 widget_box_layout">
    <div class="widget_name">
        <?= Yii::t('app','Recommended Games') ?>
</div>
<div class="widget_box">
    <?php
    foreach($model as $key => $val){
        echo "<a href='#' url-redirect='".$val['main_link']."' post='".$val['id']."'><div class='widget_item'>";
        echo "<img src='".$val['image']."' />";
        echo "<i>".$val['title']."</i>";
        echo "</div></a>";
    } ?>
</div>
</div>

