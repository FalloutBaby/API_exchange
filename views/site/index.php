<?php
/* @var $this yii\web\View */

$this->title = 'Тестовое задание';
?>
<div class="site-index">

    <?= \yii\helpers\Html::a('Работа с биржами', ['market/market'], ['class' => 'btn btn-lg btn-success']); ?>

    <?= \yii\helpers\Html::a('Перераспределить в процентах', ['market/market/rearrange'], ['class' => 'btn btn-lg btn-success']); ?>

</div>
