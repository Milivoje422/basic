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
                        'actions' => ['logout'],
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
    /**
     * Login action.
     *
     * @return string
     */
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

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
             // return \yii\helpers\Json::encode($response);
        }else{
            $response = "Faild";
            // return \yii\helpers\Json::encode($response);
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


    public function actionCategory($id)
    {
        $query = PostSearch::find()->where(["category_id" => $id]);
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

                echo "<pre>";
                print_r($feed);

            // $model->save();
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