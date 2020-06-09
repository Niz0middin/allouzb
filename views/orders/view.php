<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = $model->order_key;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

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
            'order_key',
            'client_id',
            'cost',
            'count',
            'location',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('d.m.Y H:i', $model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('d.m.Y H:i', $model->updated_at);
                },
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    if ($model->status == 1){
                        return 'В ожидании';
                    }
                    elseif ($model->status == 2){
                        return 'В процессе';
                    }
                    elseif ($model->status == 0){
                        return 'Завершенный';
                    }
                    else{
                        return '-';
                    }
                }
            ],
        ],
    ]) ?>

</div>
