<h3><br><br>Список категорий со статусом 1</h3>

<?php
	use yii\helpers\Html;

	$this->title = 'Список категорий';

	//var_dump($models);

	foreach($models as $model) {
		echo Html::a($model['title'], ['category/view', 'id' => $model['id']]);
		echo '<br>';
	}
	echo '<br><br>';
?>

