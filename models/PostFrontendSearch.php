<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use app\models\Post;

/**
* PostSearch represents the model behind the search form of 'app\models\Post'.
*/

/**
 * 
 */
class PostFrontendSearch extends Post
{
	
	public function rules()
	{
		return [
			[['text'], 'string', 'max' => 50],
		];
	}

	/**
	* Creates data provider instance with search query applied
	*
	* @param array $params
	*
	* @return ActiveDataProvider
	*/
	public function search($params)
	{
		$query = Post::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}
		$query->orFilterWhere(['like', 'title', $this->text])->orFilterWhere(['like', 'lead', $this->text])->orFilterWhere(['like', 'text', $this->text]);

		return $dataProvider;
	}

}