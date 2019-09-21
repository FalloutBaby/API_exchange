<?php

namespace app\modules\market\models;

use Yii;

/**
 * Модель для работы с биржами.
 *
 */
class Broker extends \yii\base\Model {

    /**
     * Изменение баланса по процентам
     * 
     * @param \app\modules\market\models\tables\Market $market
     * @param float $percent1 Процент рублей
     * @param float $percent2 Процент долларов
     * @param float $percent3 Процент евро
     */
    public function rearrangeSums(tables\Market $market, float $percent1, float $percent2, float $percent3) {
        $usdRub = $market->moneyRates["USDRUB"];
        $usdEur = $market->moneyRates["USDEUR"];
        $fullSum = $market->fullSum;

        $newRub = ($fullSum / 100) * $percent1 * $usdRub;
        $newUsd = ($fullSum / 100) * $percent2;
        $newEur = ($fullSum / 100) * $percent3 * $usdEur;

        $rubDiff = self::difference($market->RUB, $newRub);
        self::buySell($market, $rubDiff, "RUB", $usdRub);
        $eurDiff = self::difference($market->EUR, $newEur);
        self::buySell($market, $eurDiff, "EUR", $usdEur);
    }

    /**
     * Вычислить разницу значений
     * 
     * @param float $val1 Было
     * @param float $val2 Должно стать
     * @return float Разница
     */
    protected static function difference(float $val1, float $val2) {
        return $val2 - $val1;
    }

    /**
     * Купить/продать валюту за доллары
     * 
     * @param \app\modules\market\models\tables\Market $market
     * @param float $diff Разница с текущим балансом
     * @param string $currency Валюта, с которой совершается долларообмен
     * @param float $rates Курс
     */
    protected static function buySell(tables\Market $market, float $diff, string $currency, float $rates) {

        if ($diff > 0) {
            $market->buy("USD" . $currency, $diff);
        } elseif ($diff < 0) {
            $market->buy($currency . "USD", -$diff / $rates);
        }
    }

}
