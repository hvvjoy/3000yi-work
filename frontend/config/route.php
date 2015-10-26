<?php

return [
		'enablePrettyUrl' => true,
		//'suffix' => '.shtml',     //如果没有写suffix，就不会被程序找到，官方手册不推荐这个配置
		'rules' => [
				'task/show/<id:\w+>' => 'home/task/show',
				'<controller:\w+>/<action:\w+>' => 'home/<controller>/<action>',
		],
];