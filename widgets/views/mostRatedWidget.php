<div class="col-sm-12 widget_box_layout">
    <div class="widget_name">
        <?= Yii::t('app','Most Rated') ?>
    </div>
    <div class="widget_ll_box">
    <?php 
    foreach($model as $key => $val){
    	echo "<a href='#' url-redirect='".$val['main_link']."' post='".$val['id']."'><div class='widget_ll_item'>";
    	echo "<img src='".$val['image']."' />";
    	echo "</div></a>";
    } ?>
    </div>
</div>
