<?php 
use yii\widgets\Pjax;
?>
<h4><?= $newMarket->name; ?></h4>
<p><?= $newMarket->route; ?></p>
<?php Pjax::begin(['id' => $newMarket->id . '-pjax']) ?>
<p>Рублей <?= $newMarket->getBalances("RUB"); ?></p>
<p>Долларов <?= $newMarket->getBalances("USD"); ?></p>
<p>Евро <?= $newMarket->getBalances("EUR"); ?></p>
<?php Pjax::end() ?>
