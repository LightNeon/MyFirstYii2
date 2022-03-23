<?php

namespace app\controllers;

use yii;
use yii\web\Controller;

use app\models\Category;
use app\models\CategorySearch;

class CategoryController extends Controller
{
	/**
	* Список категорий со статусом 1 (status)
	*/
	public function actionIndex()
	{
		$models = Category::find()->where(['status'=>1])->all();
		return $this->render('index', ['models' => $models]);
	}


	/**
	* Представление отдельной категории
	*/
	public function actionView($id)
	{
		$model = Category::find()->where(['status' => 1, 'id' => $id])->one();

		if ($model) {
			return $this->render('view', ['model' => $model]);
		}
		throw new \yii\web\NotFoundHttpException('Категория не найдена');
	}




}