<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
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

    <ul class="nav nav-tabs">
        <li><a href="/stats">По продуктам</a></li>
        <li class="active"><a>По клиентам</a></li>
    </ul>

    <div class="tab-content">
        <div id="menu2" class="tab-pane fade in active" style="margin-top: 20px">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout'=> "{summary}\n{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'client_id',
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
                    [
                        'attribute' => 'cost',
                        'value' => function($model){
                            return $model->cost.' UZS';
                        },
                    ],
                    'count',
//            'updated_at',

//            ['class' => ActionColumn::className(),'template'=>'{view} {delete}' ],
                ],
            ]); ?>
        </div>
    </div>
</div>
