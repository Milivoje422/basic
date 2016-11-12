<?php 


namespace app\controllers;

use Yii;
use app\models\Feed;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Categories;
use app\models\CategoriesSearch;

use app\models\rssnews;
use app\models\rssnewsSearch;


class rssFeeds
{


	public function getRss($url)

	$rssFeeds = Feed::loadRss('http://news.yahoo.com/rss/science');

	print_r($rssFeeds);
	echo "<pre>";
	die;


}