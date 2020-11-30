<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\models\Message;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\forms\LoginForm;
use app\models\forms\MessageForm;
use app\models\forms\SignupForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'add_message'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'index', 'signin',],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return ((!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin()));
                        }
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['POST'],
                    'add_message' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * Displays Chatpage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'messageModelForm' =>  new MessageForm(),
            'messages' => Message::MessagesQuery()->All(),

        ]);
    }

    /**
     * Добавим сообщение в базу
     * @return void
     */
    public function actionAdd_message()
    {
        $messageForm = new MessageForm();
        if (Yii::$app->request->isPost) {
            if (!($messageForm->load(Yii::$app->request->post()) && $messageForm->addMessage())) {
                Yii::$app->session->addFlash('error', 'Не удалось отправить сообщение в чат');
            }
        }
        $this->redirect(['site/index']);
    }

    /**
     * Пометка сообщения удаленным 
     * @return void
     */
    public function actionDelete()
    {
        $message = Message::find()->where(['id' => Yii::$app->request->get('id')])->one();
        if (!$message->delete()) {
        }
        $this->redirect(['site/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Форма регистрации.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
