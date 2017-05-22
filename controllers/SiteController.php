<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

// Called models //
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Categories;
use app\models\PostRating;
use app\models\Posts;
use app\models\PostVisitors;
use yii\data\Pagination;



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
     * Error response page
     */
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

    /**
    * Search model which shows post anyway  sorted by post rate,
    *
    * but with query shows posts depends on query
    */
    public function actionSearch()
    {
        $query = new Posts();
        $query = $query->Search((isset($_GET['search'])? $_GET['search'] : '')); // Get query and paste him into search method as parameter


        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 20, 'totalCount' => $countQuery->count()]); // Show only 20 results rest put in pager
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('search',['models' => $models, 'pages' => $pages]); // Return everything to action layout
    }


    /**
     * Category page show posts depends on category id
     */
    public function actionCategory($id)
    {
        // Get posts and sort them according on reviews
        $query = new Posts();
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
            // Insert to body user ip address and user agent
            $body = '';
            $body .= $model->body;
            $body .= "\r\n".'User ip: '.$_SERVER['REMOTE_ADDR']."\r\n";
            $body .= 'User Agent: '.$_SERVER['HTTP_USER_AGENT'];
            $model->body = $body;
            // If is sent successfully, reload and show success alert box
            if($model->contact($model->email)){
                Yii::$app->session->setFlash('contactFormSubmitted');
                return $this->refresh();
            }
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    /**
     * Rating action
     * Returns boolean false if is already that user rated
     * Else return true and save that rating
     */
    public function actionRating()
    {
        $response = "Success";

        if(isset($_POST['data']) && isset($_POST['item'])){
            $model = new PostRating();

            $model->post_id = $_POST['item'];
            $model->raiting_value = $_POST['data'];
            $model->user_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_at = date('Y-m-d h:i:s');
        
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


    /**
     * Review action
     * Save any user preview to db
     */
    public function actionReview()
    {
       $model = new PostVisitors();

        if(isset($_POST['post']))
        {
            $model->post_id = $_POST['post'];
            $model->created_at = date('Y-m-d h:i:s');

            // Just get ip address for test project
            $model->user_ip = $_SERVER['REMOTE_ADDR'];

            if($model->save()){
                return 1;
            }
        }
       return false;
    }


    /**
     * Action for getting a content from rss
     */
    public function PasteRss($category, $url)
    {
        $feed = Yii::$app->rss_feed->loadRss($url);
        foreach ($feed->item as $item) {
            $model = new Posts();

                $formated_time = date('Y-m-d h:i:s');

                $value = json_decode(json_encode($item), true);

                $model->title       =  $value['title'];
                $model->content     =  $value['description'];
                $model->main_link   =  $value['link'];
                $model->image       =  $value['image'];
                $model->category_id =  $category;
                $model->datetime    =  $formated_time;

            if($model->save()){
                return "Success";
            }else{
                var_dump($model->errors);
            };
        }
      return true;  
    }

    /**
     * Rss action gets category id and link from db,
     * Loop that info throu
     */
    public function actionRss() 
    {
        $cat = Categories::find()->all();
        foreach ($cat as $key => $value) {
            $this->PasteRss($value->id, $value->description);
        }
        return $this->render('rss');
    }

    /**
     * Language method / change language on website
     */
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

