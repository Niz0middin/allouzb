<?php

use app\models\Category;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

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
            'name',
            [
                'attribute' => 'cost',
                'value' => function($model){
                    return $model->cost.' UZS';
                },
            ],
            [
                'attribute' => 'category_id',
                'label' => 'Категория',
                'format' => 'raw',
                'filter' => \yii\helpers\ArrayHelper::map(Category::find()->leaves()->all(), 'id', 'name'),
                'value' => function ($model) {
                    $cats = Category::find()->leaves()->all();
                    $child = false;
                    foreach ($cats as $cat){
                        if ($cat->id == $model->category->id){
                            $child = true;
                        }
                    }
                    if ($child) {
                        return $model->category->name;
                    }else{
                        return '<p style="color: red">Неправильная категория</p>';
                    }
                }
            ],
            'description:ntext',
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
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
