<?php

namespace app\controllers;

use app\models\Country;
use app\models\CountryForm;
use app\models\SearchCountry;
use app\models\Product;
use app\models\ProductForm;
use app\models\SearchProduct;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{

    public $freeAccessActions = ['index', 'about', 'contact', 'indexcountry', 'readcountry', 'indexproduct', 'readproduct'];

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
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays create country page.
     *
     * @return string
     */
    public function actionIndexcountry()
    {
        $searchModel = new SearchCountry();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('..\country\index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays create country page.
     *
     * @return string
     */
    public function actionCreatecountry()
    {
        $countryForm = new CountryForm();
        if (Yii::$app->request->post('Country') && $countryForm->createCountry(Yii::$app->request->post('Country'))) {
            Yii::$app->session->setFlash('success', 'Success');
        }

        $model = new Country();
        return $this->render('..\country\create', [
            'model' => $model
        ]);
    }

    /**
     * Displays read country page.
     *
     * @return string
     */
    public function actionReadcountry($id)
    {
        $model = Country::findOne($id);
        return $this->render('..\country\read', [
            'model' => $model
        ]);
    }

    /**
     * Displays update country page.
     *
     * @return string
     */
    public function actionUpdatecountry($id)
    {
        $model = Country::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Success');
            return $this->redirect(['readcountry', 'id' => $model->id]);
        } else {
            if (Yii::$app->request->post()) {
                Yii::$app->session->setFlash('error', 'Error.');
            }
            return $this->render('..\country\update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Delete country.
     *
     * @return string
     */
    public function actionDeletecountry($id)
    {
        if (Country::findOne($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Success');
        } else {
            Yii::$app->session->setFlash('error', 'Error.');
        }
        return $this->redirect(['indexcountry']);
    }

    /**
     * Displays create product page.
     *
     * @return string
     */
    public function actionIndexproduct()
    {
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('..\product\index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays create product page.
     *
     * @return string
     */
    public function actionCreateproduct()
    {
        $productForm = new ProductForm();
        if (Yii::$app->request->post('Product') && $productForm->createProduct(Yii::$app->request->post('Product'))) {
            Yii::$app->session->setFlash('success', 'Success');
        }

        $model = new Product();
        return $this->render('..\product\create', [
            'model' => $model
        ]);
    }

    /**
     * Displays read product page.
     *
     * @return string
     */
    public function actionReadproduct($id)
    {
        $model = Product::findOne($id);
        return $this->render('..\product\read', [
            'model' => $model
        ]);
    }

    /**
     * Displays update product page.
     *
     * @return string
     */
    public function actionUpdateproduct($id)
    {
        $model = Product::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Success');
            return $this->redirect(['readproduct', 'id' => $model->id]);
        } else {
            if (Yii::$app->request->post()) {
                Yii::$app->session->setFlash('error', 'Error.');
            }
            return $this->render('..\product\update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Delete product.
     *
     * @return string
     */
    public function actionDeleteproduct($id)
    {
        if (Product::findOne($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Success');
        } else {
            Yii::$app->session->setFlash('error', 'Error.');
        }
        return $this->redirect(['indexproduct']);
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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
