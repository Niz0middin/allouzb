<?php

use kartik\date\DatePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
<!--        --><?//= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'options' =>[
                        'readonly'=>'true'
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ])
            ],
            [
                'attribute' => 'status',
                'filter' => [1=>'В ожидании', 2=>'В процессе', 0=>'Завершенный'],
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
//            'updated_at',

            ['class' => ActionColumn::className(),'template'=>'{view} {delete}' ],
        ],
    ]); ?>


</div>
