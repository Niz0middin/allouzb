<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cart */

$this->title = \app\models\Client::findOne($_GET['id'])->id;
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cart-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
<!--            <th>Имя</th>-->
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
            <th>Создан</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model as $cart){ ?>
            <tr>
<!--                <td>--><?//= $cart->product->name ?><!--</td>-->
                <td><?= $cart['cost']/$cart['count'] ?> UZS</td>
                <td><?= $cart['count'] ?></td>
                <td><?= $cart['cost'] ?> UZS</td>
                <td><?= date('d.m.Y H:i',$cart['created_at']) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
