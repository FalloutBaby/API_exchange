<?php

namespace app\modules\market\models\tables;

use Yii;
use Faker\Factory;

/**
 * Модель биржи.
 *
 * @property string $route Url маршрут к бирже
 * @property array $moneyRates Курсы валют
 * @property int $id
 * @property string $name Название биржи
 * @property float $fullSum Вся сумма в долларах
 * @property float $EUR
 * @property float $USD
 * @property float $RUB
 */
class Market extends \yii\base\Model {

    private $apiKey;
    public $moneyRates;
    public $route;
    public $id;
    public $name;
    public $EUR;
    public $USD;
    public $RUB;

    public function __construct($config = array()) {
        parent::__construct($config);
        $faker = Factory::create();
        $this->id = $faker->randomNumber(3);
        $this->moneyRates = [
            "EURRUB" => "70.49",
            "EURUSD" => "1.1",
            "RUBEUR" => "0.014",
            "RUBUSD" => "0.016",
            "USDEUR" => "0.91",
            "USDRUB" => "64"
        ];
    }

    public function init() {
        parent::init();
        $this->apiKey = Yii::$app->params['apiKey'];
    }

    /**
     * Узнать текущий баланс
     * 
     * @param string $currency Валюта, по которой нужен баланс.
     *                         Если не задана, вернет массив всех валют
     * @return mixed Сумма или массив со всеми сумами
     */
    public function getBalances(string $currency = null) {
        $balances = [
            'RUB' => $this->RUB,
            'USD' => $this->USD,
            'EUR' => $this->EUR
        ];

        return $currency ? $balances[$currency] : $balances;
    }

    /**
     * Получить текущий курс пары валют
     * 
     * @param string $currencies
     * @return double Курс
     */
    public function getPrice(string $currencies) {
        return $this->moneyRates[$currencies];
    }

    /**
     * Покупка
     * 
     * @param string $currencies Пара валют формата "за какую валюту что покупаем"
     * @param int $amount Сколько покупаем
     */
    public function buy(string $currencies, float $amount) {
        $cur1 = substr($currencies, 0, 3);
        $cur2 = substr($currencies, 3, 3);
        $rate = $this->moneyRates[$currencies];
        $this->$cur1 -= $amount / $rate;
        $this->$cur2 += $amount * $rate;
    }

    /**
     * 
     * @return string
     */
    public function getApiKey() {
        return $this->apiKey;
    }

    /**
     * 
     * @return float
     */
    public function getFullSum() {
        return ($this->RUB * $this->getPrice("RUBUSD")) + $this->USD + ($this->EUR * $this->getPrice("EURUSD"));
    }

}
