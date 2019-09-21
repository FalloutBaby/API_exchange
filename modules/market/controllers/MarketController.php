<?php

namespace app\modules\market\controllers;

use Yii;
use yii\helpers\Url;
use app\modules\market\models\tables\Market;
use app\modules\market\models\Broker;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use Faker\Factory;

/**
 * MarketController implements the CRUD actions for Market model.
 */
class MarketController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Market models.
     * @return mixed
     */
    public function actionIndex() {
        $faker = Factory::create();

        for ($i = 0; $i < 2; $i++) {
            $markets[$i] = new Market();

            $markets[$i]->name = $faker->company();
            $markets[$i]->route = $faker->url();
            $markets[$i]->EUR = $faker->randomNumber(3);
            $markets[$i]->USD = $faker->randomNumber(4);
            $markets[$i]->RUB = $faker->randomNumber(6);
        }
        $broker = new Broker();
        $newMarket = new Market();
        if (Yii::$app->request->isAjax) {
            $get = Yii::$app->request->get();
            if ($get['action-type'] == 'get-price') {
                return $markets[0]->getPrice($get['Market']['moneyRates']);
            }
            if ($get['action-type'] == 'buy') {
                $markets[0]->buy($get['Market']['moneyRates'], $get['amount']);
                return $get['id'];
            }
            if ($get['action-type'] == 'create-new') {
                $newMarket = new Market($get['Market']['company'], $get['Market']['route']);
                return $this->renderAjax('new-market', ['newMarket' => $newMarket]);
            }
        }
        return $this->render('index', [
                    'broker' => $broker,
                    'markets' => $markets,
                    'newMarket' => $newMarket
        ]);
    }

    /**
     * Перераспределение по валютным счетам 
     * 
     * @return mixed
     */
    public function actionRearrange() {
        $faker = Factory::create();

        // Генерируется случайное процентное соотношение
        $percent1 = $faker->numberBetween(0, 99);
        $percent2 = $faker->numberBetween(0, 99 - $percent1);
        $percent3 = 100 - $percent1 - $percent2;

        for ($i = 0; $i < 2; $i++) {
            $markets[$i] = new Market();

            $markets[$i]->name = $faker->company();
            $markets[$i]->route = $faker->url();
            $markets[$i]->EUR = $faker->randomNumber(3);
            $markets[$i]->USD = $faker->randomNumber(4);
            $markets[$i]->RUB = $faker->randomNumber(6);

            $data = $markets[$i]->attributes;
            $marketsOld[$i] = new Market();
            foreach ($data as $attribute => $val) {
                $marketsOld[$i]->$attribute = $val;
            }
        }
        $broker = new Broker();

        foreach ($markets as $market) {
            $broker->rearrangeSums($market, $percent1, $percent2, $percent3);
        }

        return $this->render('rearranging', ['broker' => $broker,
                    'markets' => $markets,
                    'marketsOld' => $marketsOld,
                    'percent1' => $percent1,
                    'percent2' => $percent2,
                    'percent3' => $percent3]);
    }

}
