<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='form-group field-attribute-parentId'>
        <?= Html::label('Родитель', 'parent', ['class' => 'control-label']);?>
        <?= Html::dropdownList(
            'Category[parentId]',
            $model->parentId,
            Category::getTree($model->id),
            ['prompt' => 'No Parent (saved as root)', 'class' => 'form-control']
        );?>

    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'position')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>