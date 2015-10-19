<?php
namespace app\models;

use yii\base\Model;

class TaskForm extends Model
{
	public $title;
	public $priority;
	public $difficulty;
	public $assign_to;
	public $content;
	
	public function rules()
	{ 
		return [
				    [['title', 'priority','difficulty','assign_to','content'], 'required', 'on' => ['add']],  
		];
	}
	
	public function scenarios()
	{
		return [
				'add' =>['title', 'priority','difficulty','assign_to','content'],
		];
	}
}