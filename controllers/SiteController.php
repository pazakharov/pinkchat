<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Response;
use app\models\Message;
use yii\web\Controller;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use yii\data\ActiveDataProvider;
use app\models\forms\MessageForm;
use yii\debug\models\timeline\DataProvider;

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
                        'actions' => ['login', 'index', 'signup',],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['grant_admin_rights', 'delete', 'restore'],
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
            'usersDataProvider' => new ActiveDataProvider(['query' => User::find()]),
            'messagesDataProvider' => new ActiveDataProvider([
                'query' => Message::MessagesQuery()->andFilterWhere(['not', ['is', 'deleted_at', new \yii\db\Expression('null')]]),
                'pagination' => ['pageSize' => 7]
            ]),

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
     * Снять пометку об удалении 
     * @return void
     */
    public function actionRestore()
    {
        Message::find()->where(['id' => Yii::$app->request->get('id')])->one()->restore();

        $this->redirect(['site/index']);
    }

    /**
     * Снять пометку об удалении 
     * @return void
     */
    public function actionGrant_admin_rights()
    {
        User::grant_admin_rights(Yii::$app->request->get('id'));
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
            return $this->goHome();
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
