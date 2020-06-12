<?php

use kartik\date\DatePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
<!--        --><?//= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'product.name',
//            'product.name',
//            'order.order_key',
            'cost',
            'count',
//            [
//                'attribute' => 'created_at',
//                'value' => function ($model) {
//                    return date('d.m.Y H:i', $model->created_at);
//                },
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'created_at',
//                    'options' =>[
//                        'readonly'=>'true'
//                    ],
//                    'pluginOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-mm-dd',
//                        'todayHighlight' => true
//                    ]
//                ])
//            ],
//            'updated_at',

            ['class' => ActionColumn::className(),'template'=>'{view} {delete}' ]
        ],
    ]); ?>


</div>
