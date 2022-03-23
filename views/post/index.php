<?php
	use yii\widgets\ListView;

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	$this->title = 'Все посты';

	$searchString = yii\helpers\ArrayHelper::getValue(Yii::$app->request->queryParams, "PostFrontendSearch");

	if ($searchString) {
		$this->title = 'Результаты поиска: ';
	}

/*	$testString = 'It`s test!';

	$script = <<< JS
		$(function() {
			alert('Hello from view! ' + "$testString");
		});
	JS;*/

/*	$this->registerJs($script, yii\web\View::POS_READY);*/

?>

<div class="row">

	<?php $form = ActiveForm::begin([
		'method' => 'get',
	]); ?>

	<br><br><br>
	<div class="col-sm-12 col-md-1">
		Поиск
	</div>

	<div class="col-sm-16 col-md-16">
		<?= $form->field($searchModel, 'text')->textInput(['placeholder' => 'Введите строку для поиска'])->label(false);
		?>
	</div>

	<div class="col-sm-12 col-md-1">
		<?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>


<?php if ($searchString): ?>
	<h1>Вы искали: "<?= Html::encode($searchString['text']); ?>"</h1>
<?php endif; ?>

<h1>Список статей</h1>

<section>
	<?php
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_listItem',
			'summary' => ' ',
		]);
	?>

</section>