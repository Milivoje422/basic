<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;


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
<<<<<<< HEAD
    <!-- <link href="/web/css/jquery.rateyo.min.css" rel="stylesheet"> -->
=======
    <link href="/web/css/jquery.rateyo.min.css" rel="stylesheet">
>>>>>>> 037a45e586e584838ce11dbe539eb7cfb0d741c8
</head>
<body class="body-background">
    <div>
<?php $this->beginBody() ?> 
        <div class="navbar-custom">
            <div class="navbar-background-img">
                <div class="container" style="padding-top:40px;">
                    <div class="col-lg-3 col-sm-4 col-md-3 col-xs-6">
                        <h1 class="site_title"><strong style="color: white; font-size: 48px;">Y-news</strong></h1>
                    </div>
                    <div class="col-lg-6 col-sm-8 col-md-6  hidden-xs col-sx-3">
                        <ul class="main-navbar_custom navbar_links">
                            <li href="site/index"><?= Yii::t('app','Home') ?></li>
                            <li href="site/science"><?= Yii::t('app','Science') ?></li>
                            <li href="site/tech"><?= Yii::t('app','Tech') ?></li>
                            <li href="site/world"><?= Yii::t('app','World') ?></li>
                            <li href="site/politics"><?= Yii::t('app','Politics') ?></li>
                            <li href="site/health"><?= Yii::t('app','Health') ?></li>
                            <li href="site/contact"><?= Yii::t('app', 'Contact') ?></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-3 hidden-xs col-sx-3">
                        <input type="text" name="" placeholder="Search" class="form-control search-input_custom">
                    </div>
                    <div class="hidden-sm hidden-md hidden-lg col-xs-6">
                        <button class="btn btn_custom"><i class="glyphicon glyphicon-menu-hamburger"></i></button>
                        <ul class="navbar_small_links navbar_links">
<<<<<<< HEAD
                            <li href="site/index">Home</li>
                            <li href="site/science">Science</li>
                            <li href="site/tech">Tech</li>
                            <li href="site/world">World</li>
                            <li href="site/politics">Politics</li>
                            <li href="site/health">Health</li>
                            <li href="site/contact">Contact</li>
                        </ul>
                    </div>

=======
                            <li href="site/index"><?= Yii::t('app','Home') ?></li>
                            <li href="site/science"><?= Yii::t('app','Science') ?></li>
                            <li href="site/tech"><?= Yii::t('app','Tech') ?></li>
                            <li href="site/world"><?= Yii::t('app','World') ?></li>
                            <li href="site/politics"><?= Yii::t('app','Politics') ?></li>
                            <li href="site/health"><?= Yii::t('app','Health') ?></li>
                            <li href="site/contact"><?= Yii::t('app', 'Contact') ?></li>
                        </ul>
                    </div>
                        <select class="languages">
                            <option value="">languages</option>
                        <?php
                            foreach (Yii::$app->params['languages'] as $key => $language) {
                                echo '<option value="'.$key.'">'.$language.'</option>';
                            }
                        ?>      
                        </select>
>>>>>>> 037a45e586e584838ce11dbe539eb7cfb0d741c8
                </div>
            </div>
        </div>
        <?php 

            var_dump(Yii::$app->session->get('username'));

            var_dump(Yii::$app->user->isGuest);

        ?>
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
            <li href="site/index" class="home"><?= Yii::t('app', 'Home') ?></li>
            <li href="site/about" class="about"><?= Yii::t('app', 'About') ?></li>
            <li href="site/contact" class="contact"><?= Yii::t('app', 'Contact') ?></li>
        </ul>
    </div>
</div>
<?php $this->endBody() ?>
</div>
    <script type="text/javascript">
        $('.btn_custom').on('click', function(){
            $('.navbar_small_links').toggle(400);
        });

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

  $(function () {
  
    $(".rateyo").rateYo();
    $(".rateyo-readonly-widg").each(function() {
      var item = $(this);
    item.rateYo({
         rating: item.data('rating'),
          numStars: 5,
          precision: 2,
          minValue: 1,
          maxValue: 5
      }).on("rateyo.set", function (e, data) {
          console.log($(this).parent());

            var item_id = e.currentTarget.id;
            var rating = data.rating; 
            var url = "<?= Url::to(['site/rating']); ?>";

            $.ajax({
                method: "POST",
                data: {item : item_id, data: rating},
                url: url,
                success:function(data) {
                    console.log('success');
                }
            });            
      });
   });
  });

  $(function(){
    $('.languages').on('change', function(){

<<<<<<< HEAD
    </script>
    <!-- <script src="../web/js/jquery.rateyo.js"></script> -->
=======
        var lang = $('.languages option:selected').val();
        var url = "<?= Url::to(['site/language']); ?>";
        $.post(url,{'lang':lang}, function(data){
            location.reload();
        });
    });
  });

    </script>
    <script src="/web/js/jquery.rateyo.js"></script>
>>>>>>> 037a45e586e584838ce11dbe539eb7cfb0d741c8
</body>
</html>
<?php $this->endPage() ?>
