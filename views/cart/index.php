<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Корзинка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

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

            'product.name',
            'order.order_key',
            'cost',
            'count',
            'created_at',
            'updated_at',

            ['class' => ActionColumn::className(),'template'=>'{view} {delete}' ]
        ],
    ]); ?>


</div>
