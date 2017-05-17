

<?php
	use app\widgets\MostPlayedWidget;
	use app\widgets\MostRatedWidget;
	use app\widgets\RandomPostsWidget;
	use app\widgets\MainSliderWidget;
use app\widgets\RecommendedGamesWidget;
use app\models\rssnews;
?>

<div class="widgets_index">
	<div class="widget_ col-sm-12">
		<div class="row">
			<?php // RecommendedGamesWidget::widget() ?>

		</div>
	</div>
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
