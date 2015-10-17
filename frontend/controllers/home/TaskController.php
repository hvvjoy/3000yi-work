<?php

namespace frontend\controllers\home;


use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
//use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\BaseController;

class TaskController extends BaseController
{

	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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

	public function actionIndex(){
        $query = new \yii\db\Query();
        $tasks = $query->select('*')
                ->from('task')
                ->all();

        $projects = $query->select('*')->from('project p')
        		  ->leftjoin('project_user as pu','p.id=pu.project_id')
        		  ->where(['user_id'=>2])->limit(20)->all(); 

        $data = [
                'title' => '任务中心',
                'js' => JS,
                'css' => CSS.',css/home/index.css',
                'nav' => 'task',
                'tasks' => $tasks,
                'projects' => $projects,
            ];
		return  $this->renderPartial('index.html', $data);
	}

}	