<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

use PayPal\Api\CreditCard;
use PayPal\Exception\PaypalConnectionException;

class PayPalController extends Controller
{
//    public $freeAccessActions = ['index', 'about', 'contact', 'indexcountry', 'readcountry'];

    public function actionMakePayments() { // or whatever yours is called

        $card = new \CashMoney();
        $card->setType('visa')
            ->setNumber('4111111111111111')
            ->setExpireMonth('06')
            ->setExpireYear('2018')
            ->setCvv2('782')
            ->setFirstName('Richie')
            ->setLastName('Richardson');

        try {
            $card->create(Yii::$app->cm->getContext());
            // ...and for debugging purposes
            echo '<pre>';
            var_dump('Success scenario');
            echo $card;
        } catch (PayPalConnectionException $e) {
            echo '<pre>';
            var_dump('Failure scenario');
            echo $e;
        }

    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        //
    }

    /**
     * Displays homepage.
     */
    public function actionIndex()
    {
        //
    }

    /**
     * Displays create country page.
     */
    public function actionIndexcountry()
    {
        //
    }


    /**
     * Displays create country page.
     */
    public function actionCreatecountry()
    {
        //
    }

    /**
     * Displays read country page.
     */
    public function actionReadcountry()
    {
        //
    }

    /**
     * Displays update country page.
     */
    public function actionUpdatecountry()
    {
        //
    }

    /**
     * Delete country.
     */
    public function actionDeletecountry()
    {
        //
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        //
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        //
    }

    /**
     * Displays contact page.
     */
    public function actionContact()
    {
        //
    }

    /**
     * Displays about page.
     */
    public function actionAbout()
    {
        //
    }
}
