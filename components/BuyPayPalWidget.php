<?php

namespace app\components;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class BuyPayPalWidget extends Widget
{
    public $button;
    public $id;

    public function init()
    {
        parent::init();
        if ($this->id === null) {
            throw new InvalidConfigException('Please specify the "id" property.');
        }
        if ($this->button === null) {
            $this->button = Html::a('<span class="social social-paypal"></span>Buy(PayPal)', Url::toRoute('site/buyproduct/' . $this->id), [
                    'title' => \Yii::t('yii', 'Buy(PayPal)'),
                    'class' => 'btn btn-info'
                ]);
        }
    }

    public function run()
    {
        return Html::decode($this->button);
    }
}