<?php

use app\models\Orders;
use app\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cart */
/* @var $form yii\widgets\ActiveForm */

$products = ArrayHelper::map(Product::find()->all(), 'id', 'name');
$orders = ArrayHelper::map(Orders::find()->all(), 'id', 'order_key');

?>

<div class="cart-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($products) ?>

    <?= $form->field($model, 'order_id')->dropDownList($orders) ?>

    <?= $form->field($model, 'cost')->input('number') ?>

    <?= $form->field($model, 'count')->input('number') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
