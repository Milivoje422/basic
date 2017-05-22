<div class="col-sm-12 col-xs-12 widget_box_layout">
    <?php foreach($model as $key => $val){ ?>
    	<div class="col-sm-4">
			<div class="row">
	    	<div class="widget_name" style="padding-bottom: 20px;">
	    		<?= Yii::t('app', $key.' Games') ?>
	    	</div>
	    	<?php foreach ($val as $key => $value) { ?>
	    		<div class="col-sm-12 col-xs-12 widget_items_">
						<a href="#" url-redirect="<?= $value['main_link'] ?>" post="<?= $value['id'] ?>">
							<img src="<?= $value['image']; ?>">
						</a>
					<h4><b><?= $value->title; ?></b></h4>
					<content><?= $value->getContent($value['content'], 60); ?>...</content>
				</div>
	    	<?php } ?>
			</div>
		</div>
    <?php } ?>
</div>

