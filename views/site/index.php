

<?php

use yii\helpers\Html;
use app\widgets\MostPlayedWidget;
use app\widgets\MostRatedWidget;
use app\widgets\RandomPostsWidget;

?>


<div class="col-sm-12">
 
</div>
<div class="widgets_index">
	<div class="widget_ col-sm-12">
		<div class="row">
		<?= MostPlayedWidget::widget() ?>
		</div>
	</div>
	<div class="widget_ col-sm-12">
		<div class="row">
		<?= MostRatedWidget::widget() ?>
		</div>
	</div>
	<div class="widget_ col-sm-12">
		<div class="row">
		<?= RandomPostsWidget::widget() ?>
		</div>
	</div>
</div>