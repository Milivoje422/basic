<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

// use Yii;
use app\controllers\CategoriesController;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> -->
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="body-background">
    <div>
<?php $this->beginBody() ?> 
        <div class="navbar-custom">
            <div class="navbar-background-img">
                <div class="container" style="padding-top:40px;">
                    <div class="col-sm-3">
                        <h1 class="site_title"><strong style="color: white; font-size: 48px;">Y-news</strong></h1>
                    </div>
                    <div class="col-sm-6">
                        <ul class="main-navbar_custom navbar_links">
                            <li href="site/index">Home</li>
                            <li href="site/science">Science</li>
                            <li href="site/tech">Tech</li>
                            <li href="site/world">World</li>
                            <li href="site/politics">Politics</li>
                            <li href="site/health">Health</li>
                            <li href="site/contact">Contact</li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="" placeholder="Search" class="form-control search-input_custom">
                    </div>
                </div>
            </div>
        </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
<div class="main_footer">
    <div class="container footer-style">
        <p class="pull-left list-style-footer">Copyleft &copy; <?= date('Y')?> by <b>Y-news</b>. All Reversed</p>
        <ul class="secund-navbar navbar_links">
            <li href="site/index" class="home">Home</li>
            <li href="site/about" class="about">About</li>
            <li href="site/contact" class="contact">Contact</li>
        </ul>
    </div>
</div>
<?php $this->endBody() ?>
</div>
    <script type="text/javascript">
        $('.navbar_links li').on('click', function(){
            var base = "<?= Yii::$app->homeUrl;?>";
            window.location = base+$(this).attr('href');
        });

    
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-87323177-1', 'auto');
      ga('send', 'pageview');

        $(document).ready(function(){
                $('.ratings_stars').hover(
                // Handles the mouseover
                function() {
                    $(this).prevAll().andSelf().addClass('ratings_over');
                    $(this).nextAll().removeClass('ratings_vote'); 
                },
                // Handles the mouseout
                function() {
                    $(this).prevAll().andSelf().removeClass('ratings_over');
                    set_votes($(this).parent());
                }
            );

            $('.rate_widget').each(function(i) {
                var widget = this;
                var out_data = {
                    widget_id : $(widget).attr('id'),
                    fetch: 1
                };
                $.post(
                    'ratings.php',
                    out_data,
                    function(INFO) {
                        $(widget).data( 'fsr', INFO );
                        set_votes(widget);
                    },
                    'json'
                );
            });

            $('.ratings_stars').bind('click', function() {
                var star = this;
                var widget = $(this).parent();
                
                var clicked_data = {
                    clicked_on : $(star).attr('class'),
                    widget_id : widget.attr('id')
                };
                $.post(
                    'ratings.php',
                    clicked_data,
                    function(INFO) {
                        widget.data( 'fsr', INFO );
                        set_votes(widget);
                    },
                    'json'
                ); 
            });


        });
    </script>
</body>
</html>
<?php $this->endPage() ?>
