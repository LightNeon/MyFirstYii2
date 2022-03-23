<?php

namespace app\models;

class postArticles extends \yii\db\ActiveRecord {
	public static function getPost($id)
	{
		return new ActiveDataProvider(['query'=>Post::findOne($id)
		]);
	}

}