<?php

namespace frontend\controllers\home;


use Yii;

use frontend\controllers\BaseController;
use app\models\TaskForm;
use yii\mongodb\Query;
use yii\base\Object;

class TaskController extends BaseController
{
	protected $mongo;
	public function __construct($id,$module){
		parent::__construct($id,$module);
		$this->mongo = new Query();
	}
	public function actionIndex(){
        
		$this->mongo->select([])
		    ->from('task')
		    ->limit(10)
			->orderBy(['_id' => SORT_DESC]);
		
		$rows = $this->mongo->all();

        $data = [
                'title' => '任务中心',
                'js' => JS.',js/home/task.js',
                'css' => CSS.',css/home/index.css',
                'nav' => 'task',
                'tasks' => $rows,
            ];
		return  $this->renderPartial('index.html', $data);
	}
	
	public function actionShow(){
			$id = Yii::$app->request->get('id');
			$this->mongo->select([])
		    ->from('task')
		    ->where(['_id'=>$id]);
		
		$res = $this->mongo->one();
        $data = [
                'title' => '任务中心',
                'js' => JS,
                'css' => CSS.',css/home/index.css',
                'nav' => 'task',
                'res' => $res,
            ];
		return  $this->renderPartial('show.html', $data);
	}
	
	public function actionAdd(){
		
		$model = new TaskForm(); 
		$model->setScenario('add');  
		/*var_dump($model->load(Yii::$app->request->post(),'') );
		var_dump($model->validate());
		exit;*/
		if ($model->load(Yii::$app->request->post(),'') && $model->validate() ) { 
			//var_dump($model); exit;
			$collection = Yii::$app->mongodb->getCollection('task');
			$data = [
					'title' => $model->title,
					'priority' => $model->priority,
					'difficulty' => $model->difficulty,
					'progress' => '0', 
					'assign_to' => $model->assign_to,
					'content' => $model->content,
					'create_time' => date('Y-m-d H:i:s')
			];
			$collection->insert($data);
			//$collection->insert($model);
			//var_dump($model);exit;
			return 'success';
		} else { 
			$data = array(
					'title' => '任务中心',
					'js' => JS,
					'css' => CSS.',css/home/index.css',
					'nav' => 'task',
					'_csrf' => Yii::$app->request->getCsrfToken(),   //防csrf攻击
			);
			return $this->renderPartial('add.html',$data);
		}
		
	}

}	