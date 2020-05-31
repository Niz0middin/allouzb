<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

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

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([1 => 'Активный', 0 => 'Неактивный']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
