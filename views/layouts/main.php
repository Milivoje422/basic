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
use app\models\PostVisitors;
use app\widgets\RecommendedGamesWidget;
use kartik\social\FacebookPlugin;
use kartik\social\GooglePlugin;
use kartik\social\TwitterPlugin;

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
<div class="navbar-background">
    <div class="container">
        <div class="col-sm-6 col-xs-12 left-title">
            <h2><?= Yii::$app->params['appname']; ?></h2>
        </div>
        <div class="col-sm-6 col-xs-12 right-title-search">
            
        <!-- Search input | global post search --> 
            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                <form method="GET" action="<?= url::to(['site/search']) ?>" style="display:inline-table;">
                    <input type="text" name="search" class="form-control"  placeholder="<?= Yii::t('app','Search')?>" >
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
                        "<li><a tabindex=".$key." href='/site/category/?id=".$cat_['id']."'>".Yii::t('app',$cat_['name'])."</a></li>"; }
        $menuItems[] ="</ul></li>";

        $menuItems[] = ['label' => Yii::t('app','Search'), 'url' => ['/site/search']];
        $menuItems[] = ['label' => Yii::t('app','More'), 'url' => ['/site/more']];
        $menuItems[] = ['label' => Yii::t('app','About Us'), 'url' => ['/site/about']];
        $menuItems[] = ['label' => Yii::t('app','Contact'), 'url' => ['/site/contact']];
             if (!Yii::$app->user->isGuest && Yii::$app->user->identity->username == "admin") {
                 $menuItems[] = ['label' => Yii::t('app', 'Admin'), 'url' => ['/admin/index']];

             }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItems,
        ]);
        NavBar::end(); ?>
    <!-- End Nav Bar -->
</div>

<!-- Use later language switch -->
     <select class="languages">
        <option value="">languages</option>
        <?php foreach (Yii::$app->params['languages'] as $key => $language) { echo '<option value="'.$key.'">'.$language.'</option>'; } ?>
     </select>
<!-- =======END======= -->
<!-- Content for pages-->
    <div class="container" style="margin-bottom: 100px;">
        <?= $content ?>
    </div>
<!-- =======END=======-->

<!--Footer-->
<div class="main_footer">
    <div class="col-sm-4 col-xs-6 appName_footer"><h2><?= Yii::$app->params['appname']; ?></h2></div>
    <div class="col-sm-4 col-xs-6 nav_footer">
        <ul class="secund-navbar navbar_links">
            <li href="site/index" class="home"><?= Yii::t('app', 'Home') ?></li>
            <li href="site/about" class="about"><?= Yii::t('app', 'About') ?></li>
            <li href="site/contact" class="contact"><?= Yii::t('app', 'Contact') ?></li>
        </ul>
    </div>
    <div class="col-sm-4 col-xs-12"><p class="list-style-footer">Copyleft &copy; <?= date('Y')?> by <b>BravoArcade</b>. All Reversed</p></div>
</div>
<!--Footer END-->

<!--Recommended games modal-->
<?php $model = new PostVisitors();
        $model = $model->getAll();
        if(count($model) >= 10){ ?>
    <div id="recommendedModal" class="modal" style="z-index: 999;">
        <div class="modal-content">
            <p><?= RecommendedGamesWidget::widget() ?></p>
        </div>
    </div>
    <?php } ?>
<!-- ===========END=========== -->

    <div class="social-media">
       <ul>
           <li>
                <?= FacebookPlugin::widget(['type'=>FacebookPlugin::SHARE, 'settings' =>['size'=>'small', 'layout'=>'button_count',
                        'mobile_iframe'=>'false','href' => 'http://workproject.22web.org']]); ?>
            </li>
            <li>
                <?= GooglePlugin::widget(['type'=>GooglePlugin::SHARE, 'settings' => ['annotation'=>'bubble']]); ?>
            </li>
            <li>
                <?= TwitterPlugin::widget(['type'=>TwitterPlugin::SHARE, 'settings' => ['size'=>'default']]); ?>
            </li>
       </ul>
    </div>

<?php $this->endBody() ?>
  <script type="text/javascript">
    // Custom javaSvript and ajax calls for dinamic actions on site.
   // integred Google analistic 
    
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-87323177-1', 'auto');
      ga('send', 'pageview');

  // function for change raiting 
jQuery(document).ready(function($){
  $(function () {

    $(".rateyo").rateYo();
    $(".rateyo-readonly-widg").each(function() {
      var item = $(this);
    item.rateYo({
         rating: item.data('rating'),
          numStars: 5,
          starWidth: "16px",
          precision: 2,
          minValue: 1,
          maxValue: 5
        }).on("rateyo.set", function (e, data) {
          console.log($(this).parent());

            var item_id = e.currentTarget.id;
            var rating = data.rating;
            var url = "<?= Url::to(['site/rating']); ?>";


            // ajax call for raiting
            $.ajax({
                method: "POST",
                data: {item : item_id, data: rating},
                url: url,
                success:function(response) {
                    if(response == 0){
                        alert("You already rated this game!");
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

      // function for change languages
      $(function(){
        $('.languages').on('change', function(){

           var lang = $('.languages option:selected').val();
            var url = "<?= Url::to(['site/language']); ?>";
            $.post(url,{'lang':lang}, function(data){
                location.reload();
            });
        });
      });

      // function for post preview

      $(function(){
        $('a').on('click',function(){
          if($(this).attr('post')){
            var pathTo = "<?= Url::to(['site/review']); ?>";
            var dataView = {
              url:$(this).attr('url-redirect'),
              post:$(this).attr('post') };
              
              // ajax call for post review
              $.ajax({
                url: pathTo,

                data: dataView,
                method:"POST",
                success:function(data){ 
                  window.location.href = dataView.url;
                },
                error:function(data){
                  console.log(data,'error');
                }
              });
          }
        });
      });
});

    // Logic for recommended modal

    function setCookie() {
        var user_ip = "<?= $_SERVER['REMOTE_ADDR']; ?>";
        var now = new Date();
        var expire = new Date();
        expire.setFullYear(now.getFullYear());
        expire.setMonth(now.getMonth());
        expire.setDate(now.getDate());
        expire.setHours(now.getHours() + 3);
        expire.setMinutes(0);
        document.cookie = 'recommended_lightbox' + "=" + user_ip + "; expires=" + expire.toString() + "; path=" + 'user';
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return true;
        }
        return false;
    }

    // Get the modal
    var modal = document.getElementById('recommendedModal');
setTimeout(function(){
    if(readCookie('recommended_lightbox') !== true){

        $('#recommendedModal').fadeIn();

        $('.close').on('click',function() {
            $('#recommendedModal').fadeOut();
            setCookie();
        });

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                $('#recommendedModal').fadeOut();
                setCookie();
            }
        }
    }
},15000);


    // // Get recommended modal
    // var modal = document.getElementById('recommendedModal');

    // if(readCookie('recommended_lightbox')!== true){
    //     $(document).ready(function(){
    //         setTimeout(function(){
    //             $('#recommendedModal').fadeIn();
    //         },15000)
    //     });

    //     $('.close').on('click',function() {
    //         $('#recommendedModal').fadeOut();
    //         setCookie();
    //     });

    //     // When the user clicks anywhere outside of the modal, close it and set the cookie
    //     window.onclick = function(event) {
    //         if (event.target == modal) {
    //             $('#recommendedModal').fadeOut();
    //             setCookie();
    //         }
    //     }
    // }


// Slider widget
    jQuery(document).ready(function($) {
        // variables 
        var slides = $('#carousel_ul1 li');

                function slide(){
                var item_width = $('#carousel_ul li').outerWidth() + 5;
                var left_indent = parseInt($('#carousel_ul').css('left')) - item_width;

                    if(left_indent <= -2035){
                        left_indent = 0;
                    }

                $('#carousel_ul').animate({'left' : left_indent},{queue:false, duration:500},function(){
                    $('#carousel_ul li:last').after($('#carousel_ul li:first'));
                    $('#carousel_ul').css({'left' : '-110px'});
                });
            };

             function slideBig(){
            
                var current = slides.filter('.current'),
                    next = current.next();

                if (!next.length){next = slides.first();}

                slides.removeClass('off');
                current.removeClass('current').addClass('off');
                next.removeClass('off').addClass('current');

            var title = $('#carousel_inner1 ul .current h2').html();
            var content = $('#carousel_inner1 ul .current p').html()
            var id = $('#carousel_inner1 ul .current').attr('id');
            var link = $('#carousel_inner1 ul .current b').html();

                $('.current-game-content h3').replaceWith('<h3>'+title+'</h3>');
                $('.current-game-content p').replaceWith('<p>'+content+'</p>');
                $('.button_play_box a').attr('url-redirect',link);
                $('.button_play_box a').attr('post',id);
            } 

        function infinite(){
            setTimeout(function () {
                slide();
                slideBig();
                infinite();
            }, 15000);
        }
            var title = $('#carousel_inner1 ul .current h2').html();
            var content = $('#carousel_inner1 ul .current p').html()
            var id = $('#carousel_inner1 ul .current').attr('id');
            var link = $('#carousel_inner1 ul .current b').html();

                $('.current-game-content h3').replaceWith('<h3>'+title+'</h3>');
                $('.current-game-content p').replaceWith('<p>'+content+'</p>');
                $('.button_play_box a').attr('url-redirect',link);
                $('.button_play_box a').attr('post',id);
           
            $(window).on('load',infinite());

           


    });

    </script>


</body>
</html>
<?php $this->endPage() ?>
