<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\web\NotFoundHttpException;

use app\models\PostSearch;
use yii\data\SqlDataProvider;
use yii\data\Pagination;

use yii\data\ActiveDataProvider;
use app\models\rssnewsSearch;
use app\models\PostRatingSearch;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','language'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }



    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }




    public function actionLanguage()
    {
        if(isset($_POST['lang'])){
            Yii::$app->language = $_POST['lang'];
            $cookie = new yii\web\Cookie([
                'name' => 'lang',
                'value'=> $_POST['lang']
                ]);

            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
    }



    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(isset($_GET['query'])){
            $model = new PostSearch();
        }else{
            $query = PostSearch::find()->with('rating');
            $countQuery = clone $query;
            $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        }
        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    public function actionRating()
    {
        $response = "Success";

        if(isset($_POST['data']) && isset($_POST['item'])){
            $model = new PostRatingSearch();

            $model->post_id = $_POST['item'];
            $model->raiting_value = $_POST['data'];
        
            $model->save();
        }else{
            $response = "Faild";
        }   
    }


    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionScience()
    {
        $query = PostSearch::find()->where(["category_id" => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('science', [
             'models' => $models,
             'pages' => $pages,
        ]);  
    }


    public function actionTech()
    {
        $query = PostSearch::find()->where(["category_id" => 2]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('tech', [
             'models' => $models,
             'pages' => $pages,
        ]);    
    }

    public function actionWorld()
    {
        $query = PostSearch::find()->where(["category_id" => 3]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('world', [
             'models' => $models,
             'pages' => $pages,
        ]);   
    }

    public function actionPolitics()
    {
        $query = PostSearch::find()->where(["category_id" => 4]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('politics', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    public function actionHealth()
    {
        $query = PostSearch::find()->where(["category_id" => 5]);
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('health', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
    public function actionPasteRss($url, $category)
    {
        $feed = Yii::$app->rss_feed->loadRss($url);
        foreach ($feed->item as $item) {
            $model = new rssnewsSearch();

            $time = $item->pubDate; 
            $formated_time = date('Y-m-d h:i:s', strtotime($time));

            $model->title = $item->title;
            $model->content = $item->description;
            $model->main_link = $item->link;
            $model->category_id = $category;
            $model->datetime = $formated_time;

            $model->save();
        }
      return true;  
    }

    public function actionRss()
    {
        $this->actionPasteRss('http://news.yahoo.com/rss/science', 1);



        $this->actionPasteRss('http://news.yahoo.com/rss/tech', 2);
        


        $this->actionPasteRss('http://news.yahoo.com/rss/world', 3);



        $this->actionPasteRss('http://news.yahoo.com/rss/politics', 4);
        


        $this->actionPasteRss('http://news.yahoo.com/rss/health', 5);

        return $this->render('rss');

    }
}

?>