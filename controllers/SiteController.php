<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use yii\web\NotFoundHttpException;

use app\models\getRss;
use app\models\Categories;
use app\models\CategoriesSearch;

use app\models\rssnews;
use app\models\PostSearch;
use yii\data\SqlDataProvider;
use yii\data\Pagination;

use app\models\feed;
use yii\data\ActiveDataProvider;

// if (!ini_get('date.timezone')) {
//     date_default_timezone_set('Europe/Prague');
// }

// require_once '../rss/src/Feed.php';


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

    public function getPosts($id, $category_id)
    {

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

        $query = PostSearch::find();
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 6, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
        ]);
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

    // public function actionRss()
    // {

    //     // $r = new feed();

    //    // $feed=Yii::$app->feed->reader()->import('http://news.yahoo.com/rss/science');


    //     return $this->render('rss');
    // }
public function actionRss()
{
    $dataProvider = new ActiveDataProvider([
        'query' => PostSearch::find()->with(['user']),
        'pagination' => [
            'pageSize' => 10
        ],
    ]);

    $response = Yii::$app->getResponse();
    $headers = $response->getHeaders();

    $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

    echo \Zelenin\yii\extensions\Rss\RssView::widget([
        'dataProvider' => $dataProvider,
        'channel' => [
            'title' => function ($widget, \Zelenin\Feed $feed) {
                    $feed->addChannelTitle(Yii::$app->name);
            },
            'link'  => Url::toRoute('/', true),
            'description' => 'Posts ',
            'language' => function ($widget, \Zelenin\Feed $feed) {
                return Yii::$app->language;
            },
            'image'=> function ($widget, \Zelenin\Feed $feed) {
                $feed->addChannelImage('http://example.com/channel.jpg', 'http://example.com', 88, 31, 'Image description');
            },
        ],
        'items' => [
            'title' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->name;
                },
            'description' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return StringHelper::truncateWords($model->content, 50);
                },
            'link' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return Url::toRoute(['post/view', 'id' => $model->id], true);
                },
            'author' => function ($model, $widget, \Zelenin\Feed $feed) {
                    return $model->user->email . ' (' . $model->user->username . ')';
                },
            'guid' => function ($model, $widget, \Zelenin\Feed $feed) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $model->updated_at);
                    return Url::toRoute(['post/view', 'id' => $model->id], true) . ' ' . $date->format(DATE_RSS);
                },
            'pubDate' => function ($model, $widget, \Zelenin\Feed $feed) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $model->updated_at);
                    return $date->format(DATE_RSS);
                }
        ]
    ]);
            return $this->render('rss', [
             'model' => $model,
        ]);


}

}

