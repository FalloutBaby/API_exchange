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
                'id' => 'form-create-new-' . $newMarket->id,
                'ajaxParam' => 'ajax',
                'action' => 'market'
    ]);
    ?>

    <div class="form-group">
        <?= Html::hiddenInput('action-type', 'create-new'); ?>
        <?=
        $form->field($newMarket, 'name')->label('Биржа');
        ?>
        <?=
        $form->field($newMarket, 'route')->label('url');
        ?>
        <div class="row">
            <div class="col-xs-6">
                <?=
                Html::submitButton('Добавить', ['name' => 'get-price',
                    'class' => 'btn btn-success']);
                ?></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div id="created"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#form-create-new-<?= $newMarket->id; ?>").on("beforeSubmit", function () {
            var data = $(this).serialize();
            $.ajax({
                url: 'market/index',
                type: 'GET',
                data: data,
                success: function (res) {
                    $(#created).html(res);
                },
                error: function () {
                    alert('Error!');
                }
            });
            return false;
        });
    });
</script>