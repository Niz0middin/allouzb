<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<!--    --><?php //echo DetailView::widget([
//        'model' => $model,
//        'attributes' => [
//            'id',
//            'name',
//            'tree',
//            'lft',
//            'rgt',
//            'depth',
//            'position',
//            [
//                'attribute' => 'created_at',
//                'value' => function($model){
//                    return date('Y-m-d h:i', $model->created_at);
//                }
//            ],
//            [
//                'attribute' => 'updated_at',
//                'value' => function($model){
//                    return date('Y-m-d h:i', $model->updated_at);
//                }
//            ],
//        ],
//    ]) ?>

</div>
