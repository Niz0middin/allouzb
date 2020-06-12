<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\CartSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cart-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <!--    --><?//= $form->field($model, 'id') ?>

        <!--    --><?//= $form->field($model, 'product_id') ?>

        <!--    --><?//= $form->field($model, 'order_id') ?>

        <!--    --><?//= $form->field($model, 'cost') ?>

        <!--    --><?//= $form->field($model, 'count') ?>

        <!--    --><?php // echo $form->field($model, 'created_at') ?>

        <div class="col-md-3">
            <?= $form->field($model, 'from')->widget(DatePicker::class, [
                'options' =>[
                    'autocomplete'=>'off',
                    'readonly'=>'true',
                ],
                'removeButton' => false,
                'pluginOptions' => [
                    'language' => 'ru',
                    'autoclose' => true,
                ],
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'to')->widget(DatePicker::class, [
                'options' =>[
                    'autocomplete'=>'off',
                    'readonly'=>'true',
                ],
                'removeButton' => false,
                'pluginOptions' => [
                    'language' => 'ru',
                    'autoclose' => true,
                ],
            ]) ?>
        </div>

            <?php // echo $form->field($model, 'updated_at') ?>

            <div class="form-group" style="margin-top: 25px">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
            </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
