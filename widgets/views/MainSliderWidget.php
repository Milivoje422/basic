<div id='carousel_container'>
    <div id='carousel_inner1'>
        <ul id='carousel_ul1'>
            <?php foreach($model as $key => $val){ ?>
                <li class="<?= $key == 0? 'current':' '?>" id="<?= $val['id']; ?>"><a href="#"><img src="<?= $val['image']; ?>" /></a>
                    <h2><?= $val['title']; ?></h2>
                    <p><?= $val->getContent($val['content'],100).'...'; ?></p>
                    <b><?= $val['main_link'];?></b>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div id='carousel_inner'>
    <div class="current-game-content" style="position: absolute; top: -4px; margin-left: 10px;">
    	<h3></h3>
    	<p></p>
    	<div class="button_play_box" style="float: left; margin: 0px;">
            <a href="#" url-redirect='' post='' class="btn btn-warning button_play" role="button">
            <?= Yii::t('app','Play now'); ?>
            <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
            </a>
        </div>
    </div>
        <ul id='carousel_ul'>
            <?php foreach($model as $key => $val){ ?>
                <li class="empty "><a href="#"><img src="<?= $val['image']; ?>" /></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<style type="text/css">
    #carousel_ul1 {
        position:relative;
        padding: 0;
        margin: 0;
        overflow:hidden;
        height: 185px;
    }
    #carousel_ul1 li {
        width:200px;
        height: 185px;
        display: block;
        z-index: 1;
        -webkit-transition: transform 1s;
        -moz-transition: transform 1s;
        -ms-transition: transform 1s;
        -o-transition: transform 1s;
        transition: transform 1s;

        -webkit-transform: translateX(200px);
        -moz-transform: translateX(200px);
        -ms-transform: translateX(200px);
        -o-transform: translateX(200px);
        transform: translateX(200px);
        left:0; top:0;
        position:absolute;
        overflow:hidden;
    }
    #carousel_ul1 li.current{
        -webkit-transform: translateX(0%);
        -moz-transform: translateX(0%);
        -ms-transform: translateX(0%);
        -o-transform: translateX(0%);
        transform: translateX(0%);
        z-index:10;
    }
    #carousel_ul1 li.off{
        -webkit-transform: translateX(-200px);
        -moz-transform: translateX(-200px);
        -ms-transform: translateX(-200px);
        -o-transform: translateX(-200px);
        transform: translateX(-200px);
        z-index:10;
    }
    #carousel_ul1 li.current h3{
        position: absolute;top: 0px; left: 200px;
        z-index: 999;
    }
    #carousel_ul1 li.current p{
        position: absolute;top: 80px; left: 200px;
        z-index: 999;
    }

#carousel_inner1 {
    float: left;
    width: 21%;
    overflow: hidden;
    background: #F0F0F0;
}

#carousel_ul1 li img {
    cursor:pointer;
    border:0px;
    width: 200px;
}

#carousel_inner {
    margin-top: 123px;
    float: right;
    width: 79%;
    overflow: hidden;
    background: #F0F0F0;
}

#carousel_ul {
    position: relative;
    left: -63px;
    list-style-type: none;
    margin: 0px;
    padding: 0px;
    width: 9999px;
    padding-bottom: 0;
}
#left_scroll img, #right_scroll img{
    cursor: pointer;
    cursor: hand;
}

#carousel_ul li{
    float: left;
    width: 63px;
    padding: 0px;
    height: 60px;
    margin-top: 0px;
    margin-left: 0px;
    margin-right: 5px;
}

#carousel_ul li img {
    cursor: hand;
    border: 0px;
    width: 63px;
}

#left_scroll, #right_scroll{
    float:left;
    height:130px;
    width:15px;
    background: #C0C0C0;
}
</style>
