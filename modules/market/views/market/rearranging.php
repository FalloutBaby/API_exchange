<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $market app\modules\market\models\tables\Market */

$this->title = 'Биржи';
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
</head>

<div class="market-index">

    <h5>Процент Рублей => <?= $percent1 ?>%</h5>
    <h5>Процент Долларов => <?= $percent2 ?>%</h5>
    <h5>Процент Евро => <?= $percent3 ?>%</h5>

    <div class="row">
        <div class="col-xs-6">
            <?php foreach ($marketsOld as $i => $market): ?>
                <h4><?= $market->name; ?></h4>
                <p><?= $market->route; ?></p>
                <?php Pjax::begin(['id' => $market->id . '-pjax']) ?>
                <p>Рублей <?= $market->getBalances("RUB"); ?></p>
                <p>Долларов <?= $market->getBalances("USD"); ?></p>
                <p>Евро <?= $market->getBalances("EUR"); ?></p>
                <p>Сумма в Дол. <?= $market->getFullSum(); ?></p>
                <?php Pjax::end() ?>

            <?php endforeach; ?>
        </div>
        <div class="col-xs-6">
            <?php foreach ($markets as $i => $market): ?>
                <h4><?= $market->name; ?></h4>
                <p><?= $market->route; ?></p>
                <?php Pjax::begin(['id' => $market->id . '-pjax']) ?>
                <p>Рублей <?= $market->getBalances("RUB"); ?></p>
                <p>Долларов <?= $market->getBalances("USD"); ?></p>
                <p>Евро <?= $market->getBalances("EUR"); ?></p>
                <p>Сумма в Дол. <?= $market->getFullSum(); ?></p>
                <?php Pjax::end() ?>

            <?php endforeach; ?>
        </div>
    </div>
</div>
