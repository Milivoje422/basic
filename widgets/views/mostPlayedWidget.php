<div class="col-sm-12 widget_box_layout">
    <div class="widget_name">
        <?= Yii::t('app','Most Played') ?>
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
