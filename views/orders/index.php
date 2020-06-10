<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    tr:hover{
        cursor: pointer!important;
    }
    .input-group-addon{
        background-color: white!important;
    }
    input{
        background-color: white!important;
    }
</style>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
<!--        --><?//= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function ($model, $key, $index, $grid){
            switch ($model->status) {
                case 1:
                    $status = 'warning';
                    break;
                case 2:
                    $status = 'info';
                    break;
                case 0:
                    $status = 'success';
                    break;
                default:
                    $status = 'default';
            }
            return [
                'id' => $key,
                'ondblclick' => 'location.href="'
                    . Yii::$app->urlManager->createUrl('/orders/view')
                    .'?id="+(this.id)',
                'class' => $status
            ];
        },
        'layout'=> "{summary}\n{items}\n{pager}",
        'tableOptions' => [
            'class' => 'table table-bordered table-striped table-hover',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_key',
            'tel',
            [
                'attribute' => 'client_id',
                'value' => function($model){
                    if (isset($model->client->name)){
                        return "<a href='https://t.me/".$model->client->name."' target='_blank'>".$model->client->name."</a>";
                    }else return '-';
                },
                'format' => 'raw',
                'label' => 'Телеграм'
            ],
            'time',
//            'client_id',
            [
                'attribute' => 'location',
                'value' => function($model){
                    $a = $model->location;
                    if (filter_var($a, FILTER_VALIDATE_URL)) {
                        return "<a href='$model->location' target='_blank'>$model->location</a>";
                    }else return $model->location;
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'cost',
                'value' => function($model){
                    return $model->cost.' UZS';
                },
            ],
            'count',
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
                'filter' => [1=>'Новый', 2=>'В процессе', 0=>'Завершенный'],
                'value' => function($model){
                    if ($model->status == 1){
                        return 'Новый';
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

//            ['class' => ActionColumn::className(),'template'=>'{view} {delete}' ],
        ],
    ]); ?>


</div>
