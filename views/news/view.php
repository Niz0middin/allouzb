<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sale-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'start',
                'value' => function($model){
                    return date('Y-m-d h:i', $model->start);
                }
            ],
            [
                'attribute' => 'end',
                'value' => function($model){
                    return date('Y-m-d h:i', $model->end);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    if ($model->status == 1){
                        return 'Активный';
                    }
                    else{
                        return 'Неактивный';
                    }
                }
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function($model){
                    return "<img style='max-height: 200px' src='$model->img'>";
                }
            ],
        ],
    ]) ?>

</div>
