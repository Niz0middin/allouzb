<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(\app\models\Category::find()->leaves()->all(), 'id', 'name'),['prompt' => 'Select']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

    <?php
    echo $form->field($model, 'img')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder',
        'filter'        => 'image',
        'template'      => '<div class="input-group"><span class="input-group-btn">{button}</span>{input}</div>',
        'options'       => ['class' => 'form-control','readonly' => true, 'style' => 'background-color:white!important'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false
    ]);
    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([1 => 'Активный', 0 => 'Неактивный']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
