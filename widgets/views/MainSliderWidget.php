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
