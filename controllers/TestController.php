<?php

namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{

	public function actionIndex()
	{
		$name = 'Евгения';
		return $this->render('index', ['nameee' => $name
		]);
	}

	public function actionPage()
	{
		echo "Hello! This is actionPage."."--->";
		echo __METHOD__;
	}
}