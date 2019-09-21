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
                'id' => 'form-get-price-' . $market->id,
                'action' => 'index'
    ]);
    ?>

    <div class="form-group">
        <?= Html::hiddenInput('id', $market->id); ?>
        <?= Html::hiddenInput('action-type', 'get-price'); ?>
        <?=
        $form->field($market, 'moneyRates')->listBox(["RUBEUR" => "RUBEUR",
            "RUBUSD" => "RUBUSD", "USDRUB" => "USDRUB"], [])->label('Курсы валют');
        ?>
        <div class="row">
            <div class="col-xs-6">
                <?=
                Html::submitButton('Узнать курс', ['name' => 'get-price',
                    'class' => 'btn btn-success']);
                ?></div>
            <div class="col-xs-6">
                <?php include 'rate.php'; ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form-get-price-<?= $market->id; ?>").on("beforeSubmit", function () {
            var data = $(this).serialize();
            $.ajax({
                url: 'market/index',
                type: 'GET',
                data: data,
                success: function (res) {
                    $("#show-price-<?= $market->id; ?>").html(res);
                },
                error: function () {
                    alert('Error!');
                }
            });
            return false;
        });
    });
</script>