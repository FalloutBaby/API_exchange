<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $market app\modules\market\models\tables\Market */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="market-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'form-buy-' . $market->id,
                'action' => 'index'
    ]);
    ?>

    <div class="form-group">
        <?= Html::hiddenInput('id', $market->id); ?>
        <?= Html::hiddenInput('action-type', 'buy'); ?>
        <?=
        $form->field($market, 'moneyRates')->listBox(["RUBEUR" => "RUB -> EUR",
            "RUBUSD" => "RUB -> USD", "USDRUB" => "USD -> RUB"], [])->label('Перевод');
        ;
        ?>
        <?=
        Html::input('number', 'amount');
        ?>
        <div class="row">
            <div class="col-xs-6">
                <?=
                Html::submitButton('Купить', ['name' => 'get-price',
                    'class' => 'btn btn-success']);
                ?></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form-buy-<?= $market->id; ?>").on("beforeSubmit", function () {
            var data = $(this).serialize();
            $.ajax({
                url: 'market/index',
                type: 'GET',
                data: data,
                success: function (res) {
//                    $.pjax.reload({
//                        container: "#" + res + "-pjax"});
                },
                error: function () {
                    alert('Error!');
                }
            });
            return false;
        });
    });
</script>