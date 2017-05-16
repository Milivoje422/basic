

<?php
	use app\widgets\MostPlayedWidget;
	use app\widgets\MostRatedWidget;
	use app\widgets\RandomPostsWidget;
	use app\widgets\MainSliderWidget;
use app\models\rssnews;
?>

<div class="widgets_index">
	<div class="widget_ col-sm-12">
		<div class="row">
			<?php // MainSliderWidget::widget() ?>


			<?php

				$model = new rssnews();
				$model = $model->recommendedLogic();
//
			$cats = array();
			$posts = array();

				echo "<pre>";


					foreach($model as $key => $val){
						$cats[]= $val['category_id'];
						$posts[] = $val['id'];
				}


		$posts = array_unique($posts);
		$cats = array_unique($cats);
			$arr = array($posts,$cats);

			$recommended = new rssnews;

			$c = implode(",",$cats);
			$p = implode(",",$posts);

			$query = "SELECT * FROM rssnews WHERE category_id IN ({$c}) AND id NOT IN ({$p}) ORDER BY RAND() LIMIT 20 ";

			$return = rssnews::findBySQL($query)->all();

			print_r($return);










			die;




			?>



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
