<?php

use kartik\datetime\DateTimePicker;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
$model->start = isset($model->start) ? date('d.m.Y h:i', $model->start):'';
$model->end = isset($model->end) ? date('d.m.Y h:i', $model->end):'';
?>
<style>
    input{
        background-color: white!important;
    }
</style>
<div class="sale-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
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
            <?php
            echo $form->field($model, 'text')->textarea(['rows' => 5]);
            ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'start')->widget(DateTimePicker::class, [
                        'options' =>[
                            'autocomplete'=>'off',
                            'readonly'=>'true'
                        ],
                        'pluginOptions' => [
//                            'format' => 'dd.mm.yyyy hh:ii',
                            'language' => 'ru',
                            'autoclose' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'end')->widget(DateTimePicker::class, [
                        'options' =>[
                            'autocomplete'=>'off',
                            'readonly'=>'true'
                        ],
                        'pluginOptions' => [
//                            'format' => 'dd.mm.yyyy HH:ii',
                            'language' => 'ru',
                            'autoclose' => true,
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
