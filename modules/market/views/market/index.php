<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\market\models\filters\MarketFilter */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Биржи';
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
</head>

<div class="market-index">

    <?php foreach ($markets as $i => $market): ?>
        <h4><?= $market->name; ?></h4>
        <p><?= $market->route; ?></p>
        <?php Pjax::begin(['id' => $market->id . '-pjax']) ?>
        <p>Рублей <?= $market->getBalances("RUB"); ?></p>
        <p>Долларов <?= $market->getBalances("USD"); ?></p>
        <p>Евро <?= $market->getBalances("EUR"); ?></p>
        <?php Pjax::end() ?>
        <div class="row">
            <div class="col-xs-4"><?php include '_form.php'; ?></div>
            <div class="col-xs-4"><?php include '_buyForm.php'; ?></div>
        </div>

    <?php endforeach; ?>
    <?php include '_createForm.php'; ?>
</div>
