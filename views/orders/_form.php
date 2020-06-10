<?php

use app\models\Client;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */

$clients = ArrayHelper::map(Client::find()->all(), 'id', 'id');

?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//= $form->field($model, 'order_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_id')->dropDownList($clients, ['prompt' => 'Select']) ?>

    <?= $form->field($model, 'cost')->input('number') ?>

    <?= $form->field($model, 'count')->input('number') ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([1=>'Новый', 2=>'В процессе', 0=>'Завершенный']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
