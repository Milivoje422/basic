<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 5/18/2017
 * Time: 9:19 PM
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Users Api premissions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-12 main_box_layout">
    <div class="cat_name">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <div style="float: right;">
        <?php
        echo Html::beginForm(['/site/logout'], 'post');
        echo Html::submitButton(Yii::t('app','Logout'));
        echo Html::endForm();
        ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'id',
                'user_ip',
                'datetime',
                'visited',
                'last_get',
                'status',
            ['class' => 'yii\grid\ActionColumn',
            'header'=>'Actions',
            'template' => '{edit}{delete}',
            'buttons' => [
                'edit' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-warning-sign"></span>', ['status', 'id' => $model->id], [
                        'class' => '',
                        'data' => [
                            'confirm' => 'Are you sure you want to change status for this user?',
                            'method' => 'post',
                        ],
                    ]);
                },
                'delete' => function($url, $model){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span> ', ['delete', 'id' => $model->id], [
                        'class' => '',
                        'data' => [
                            'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                            'method' => 'post',
                        ],
                    ]);
                }

            ]
            ],
        ],
    ]); ?>
</div>

