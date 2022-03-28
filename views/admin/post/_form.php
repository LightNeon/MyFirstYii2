<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Category;
use floor12\files\components\FileBehavior;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
    	'data' => Category::getList(),
    	'options' => ['placeholder' => 'Выберите категорию...'],
    	'pluginOptions' => [
    		'allowClear' => true
    ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'lead')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    

    

    <?= $form->field($model, 'text')->widget(TinyMce::className()); ?>
    
    <div class="col-md-4">
        <?= $form->field($model, 'mainImage')->widget(floor12\files\components\FileInputWidget::class) ?>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>