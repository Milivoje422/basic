<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

// Called models //
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Categories;
use app\models\rssnewsSearch;
use app\models\PostRating;
use app\models\rssnews;
use app\models\PostVisitors;

use yii\data\SqlDataProvider;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;



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

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
        return $this->render('index');
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

    public function actionMore(){
        $query = Categories::find()->all();

        return $this->render('more',[
            'model' => $query ]);
    }

    public function actionSearch()
    {
        $model = new Rssnews();
        return $this->render('search');
    }

    // category page depends on category id

    public function actionCategory($id)
    {
        // Get posts and sort them according on reviews
        $query = new rssnews();
        $query = $query->categorySearch($id);

        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 4, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        // Get category according on GET $id | `Category id` 
        $cat = Categories::find()->where(['id' => $id])->one();

        return $this->render('category', [
             'models' => $models,
             'pages' => $pages,
             'cat' => $cat
        ]);    
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->contact($model->email)){
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
            }
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    // Rating action with return method if is already rated

    public function actionRating()
    {
        $response = "Success";

        if(isset($_POST['data']) && isset($_POST['item'])){
            $model = new PostRating();

            $model->post_id = $_POST['item'];
            $model->raiting_value = $_POST['data'];
            $model->user_ip = $_SERVER['REMOTE_ADDR'];
        
            $query = PostRating::find()
            ->andWhere(['user_ip' => $model->user_ip])
            ->andWhere(['post_id' => $model->post_id])
            ->one();

            if($query['post_id']){
                $response = 0;
                return \yii\helpers\Json::encode($response); 
            
            }else{
                
                if($model->save()){
                    return \yii\helpers\Json::encode($model);   
                }else{
                    return \yii\helpers\Json::encode($model->errors);
                };
            }
             
        }else{
            $response = "Faild";
            // return \yii\helpers\Json::encode($response);
        }   
    }

    // Review function which count previews

    public function actionReview()
    {
       $model = new PostVisitors();

        if(isset($_POST['post']))
        {
            $model->post_id = $_POST['post'];

            // Just get ip address for test project
            $model->user_ip = $_SERVER['REMOTE_ADDR'];

            if($model->save()){
                return 1;
            }
        }
       return false;
    }


    // Action for getting a content from rss

    public function actionPasteRss($category, $url)
    {
        $feed = Yii::$app->rss_feed->loadRss($url);
        foreach ($feed->item as $item) {
            $model = new rssnews();

                $time = $item->pubDate; 
                $formated_time = date('Y-m-d h:i:s');

                $value = json_decode(json_encode($item), true);

                $model->title       =  $value['title'];
                $model->content     =  $value['description'];
                $model->main_link   =  $value['link'];
                $model->image       =  $value['image'];
                $model->category_id =  $category;
                $model->datetime    =  $formated_time;

            if($model->save()){
            
            }else{
                var_dump($model->errors);
            };
        }
      return true;  
    }


    // links for rss and action wcich starts data upload to database 
    public function actionRss() 
    {
        $cat = Categories::find()->all();
        foreach ($cat as $key => $value) {
            $this->actionPasteRss($value->id, $value->description);
        }
        return $this->render('rss');
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

}

