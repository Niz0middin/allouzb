<?php

use app\models\Product;
use kartik\date\DatePicker;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
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

    <ul class="nav nav-tabs">
        <li class="active"><a>По продуктам</a></li>
        <li><a href="/stats/client">По клиентам</a></li>
    </ul>

    <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active" style="margin-top: 20px">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions'=>function ($model, $key, $index, $grid){
                    return [
                        'id' => $model->product_id,
                        'ondblclick' => 'location.href="'
                            . Yii::$app->urlManager->createUrl('/stats/view')
                            .'?id="+(this.id)',
                    ];
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'product_id',
                        'value' => function($model){
                            return $model->product->name;
                        },
                        'filter' => ArrayHelper::map(Product::find()->all(), 'id', 'name')
                    ],
//            'product.name',
//            'order.order_key',
                    [
                        'attribute' => 'cost',
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'count',
                        'filter' => false,
                    ],
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

//                    ['class' => ActionColumn::className(),'template'=>'{view} {delete}' ]
                ],
            ]); ?>
        </div>
    </div>




</div>
