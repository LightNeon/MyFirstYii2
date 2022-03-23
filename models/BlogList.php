<?php

namespace app\models;

class BlogList extends \yii\db\ActiveRecord {

	public static function tableName()
	{
		return 'post'; //name table of the DB
	}


	/*
	* Get all articles.
	*/
	public static function getAll()
	{
		$data = self::find()->all();
		return $data;
	}


	/**
	* Get selected article.
	*/
/*	public static function actionView($id)
	{
		$post = Post::find()->where(['id' => $id])->one();

		if ($post) {
			return $this->render('view', ['model' => $post]);
		}
		throw new \yii\web\NotFoundHttpException('Пост не найден');
	}*/

}