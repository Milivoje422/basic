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
    <!-- <link href="../../web/css/jquery.rateyo.min.css" rel="stylesheet"> -->
</head>
<body class="body-background">
<?php $this->beginBody() ?>
<?php 
$cat = Categories::find()->all();
NavBar::begin([
                'options' => [
                    'class' => 'nav',
                    'role' => 'navigation',
                    'style' => 'padding:0px;'
                ],
            ]);

            $menuItems = [
                ['label' => Yii::t('app','Home'), 'url' => ['/site/index']],
            ];
            $menuItems[] = "
            <li class='dropdown'>
                <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">".Yii::t('app','Categories')."</a>
                    <ul id=\"yw3\" class=\"dropdown-menu\">";
                        foreach ($cat as $key => $cat_){ 
                            $menuItems[] =  
                            "<li><a tabindex=".$key." href='/site/category/?id=".$cat_['id']."'>".$cat_['name']."</a></li>"; }
            $menuItems[] ="</ul></li>";


         
            $menuItems[] = ['label' => Yii::t('app','Contact'), 'url' => ['/site/contact']];
            // if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin)
            //     $menuItems[] = ['label' => Yii::t('user','Admins permissions'), 'url' => ['/user/admin/index']];

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left row nav_style'],
                'items' => $menuItems,
            ]);
            NavBar::end();

?>

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
       
        <?= $content ?>
    </div>
<!-- <div class="main_footer">
    <div class="container footer-style">
        <p class="pull-left list-style-footer">Copyleft &copy; <?= date('Y')?> by <b>Y-news</b>. All Reversed</p>
        <ul class="secund-navbar navbar_links">
            <li href="site/index" class="home"><?= Yii::t('app', 'Home') ?></li>
            <li href="site/about" class="about"><?= Yii::t('app', 'About') ?></li>
            <li href="site/contact" class="contact"><?= Yii::t('app', 'Contact') ?></li>
        </ul>
    </div>
</div> -->
<?php $this->endBody() ?>
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
                success:function(response) {
                    if(response == 0){
                        alert("Can't rate!");
                    }else{
                        alert("Thanks For Rating!");
                    }
                },
                error:function(data) {
                    console.log('error');
                    console.log(data);
                }
            });            
        });
    });
    });

  $(function(){
    $('.languages').on('change', function(){

       var lang = $('.languages option:selected').val();
        var url = "<?= Url::to(['site/language']); ?>";
        $.post(url,{'lang':lang}, function(data){
            location.reload();
        });
    });
  });
    </script>
</body>
</html>
<?php $this->endPage() ?>
