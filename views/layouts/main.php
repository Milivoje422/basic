<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\Categories;


AppAsset::register($this);
?>
    <!-- Main layout -->

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="body-background">
<?php $this->beginBody() ?>
<?php $cat = Categories::find()->all(); ?>
<div class="navbar-background" style="background: linear-gradient(to bottom, #52a3c3, #185873);">
    <div class="container">
        <div class="col-sm-6 col-xs-12 left-title">
            <h2><?= Yii::$app->params['appname']; ?></h2>
        </div>
        <div class="col-sm-6 col-xs-12 right-title-search">
            
        <!-- Search input | global post search --> 
            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                <form method="GET" action="search" style="display:inline-table;">
                    <input type="text" name="search" class="form-control"  placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>  
                    </span>
                </form>
                </div>
            </div>
        <!-- End of search -->

        </div>
    </div>
    <!-- Nav Bar -->
        <?php 
        NavBar::begin([
            'options' => [
                // 'class' => 'navbar-nav',
                // 'role' => 'navigation',
                'style' => 'background:transparent; border:0px;'
            ],
        ]);

        $menuItems = [['label' => Yii::t('app','Home'), 'url' => ['/site/index']]];
        $menuItems[] = "
        <li class='dropdown'>
            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">".Yii::t('app','Categories')."</a>
                <ul id=\"yw3\" class=\"dropdown-menu\">";
                    foreach ($cat as $key => $cat_){ 
                        $menuItems[] =  
                        "<li><a tabindex=".$key." href='/site/category/?id=".$cat_['id']."'>".$cat_['name']."</a></li>"; }
        $menuItems[] ="</ul></li>";

        $menuItems[] = ['label' => Yii::t('app','Search'), 'url' => ['/site/search']];
        $menuItems[] = ['label' => Yii::t('app','More'), 'url' => ['/site/more']];
        $menuItems[] = ['label' => Yii::t('app','About Us'), 'url' => ['/site/about']];
        $menuItems[] = ['label' => Yii::t('app','Contact'), 'url' => ['/site/contact']];
            // if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin)
            //     $menuItems[] = ['label' => Yii::t('user','Admins permissions'), 'url' => ['/user/admin/index']];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItems,
        ]);
        NavBar::end(); ?>
    <!-- End Nav Bar -->
</div>
        <!-- Use later language switch -->

       <!--  <select class="languages">
                    <option value="">languages</option>
                <?php
                    // foreach (Yii::$app->params['languages'] as $key => $language) {
                    //     echo '<option value="'.$key.'">'.$language.'</option>';
                    // }
                ?>      
                </select>

                use later !

                 <?php// Breadcrumbs::widget([
            //'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        //]) ?>
               -->
              



    <div class="container">
       
        <?php // $content ?>
    </div>
<div class="main_footer">
    <div class="col-sm-4 col-xs-6 appName_footer"><h2><?= Yii::$app->params['appname']; ?></h2></div>
    <div class="col-sm-4 col-xs-6 nav_footer">
        <ul class="secund-navbar navbar_links">
            <li href="site/index" class="home"><?= Yii::t('app', 'Home') ?></li>
            <li href="site/about" class="about"><?= Yii::t('app', 'About') ?></li>
            <li href="site/contact" class="contact"><?= Yii::t('app', 'Contact') ?></li>
        </ul>
    </div>
    <div class="col-sm-4 col-xs-12"><p class="list-style-footer">Copyleft &copy; <?= date('Y')?> by <b>Y-news</b>. All Reversed</p></div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
