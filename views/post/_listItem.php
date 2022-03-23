<?php
	use yii\helpers\Html;

	$this->title = 'Список статей';
?>

<div>
	<h3>
		<?= Html::a($model['title'], ['post/view', 'id' => $model['id']]) ?>
	</h3>
	<p><?= $model->lead ?></p>
</div>