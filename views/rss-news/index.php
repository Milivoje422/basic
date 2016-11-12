<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\rssnewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rssnews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rssnews-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rssnews', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'title',
            'content',
            'datetime',
            // 'raiting',
            // 'preview',
            // 'main_link',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
