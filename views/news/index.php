<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    input{
        background-color: white!important;
    }
</style>
<div class="sale-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'start',
                'value' => function ($model) {
                    return date('Y-m-d h:i', $model->start);
                },
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'start',
                    'options' =>[
                        'readonly'=>'true'
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
//                        'format' => 'dd.mm.yyyy hh:ii'
                    ]
                ])
            ],
            [
                'attribute' => 'end',
                'value' => function ($model) {
                    return date('Y-m-d h:i', $model->end);
                },
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'end',
                    'options' =>[
                        'readonly'=>'true'
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
//                        'format' => 'dd.mm.yyyy hh:ii'
                    ]
                ])
            ],
            [
                'attribute' => 'status',
                'filter' => [1=>'Активный', 0=>'Неактивный'],
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
                    return "<img style='max-height: 100px' src='$model->img'>";
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
