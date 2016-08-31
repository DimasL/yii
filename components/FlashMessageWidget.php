<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class FlashMessageWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        $this->message = '';
        if (\Yii::$app->session->hasFlash('success')):
            $this->message = '<div class="alert alert-success">Success.</div>';
        elseif (\Yii::$app->session->hasFlash('error')):
            $this->message = '<div class="alert alert-error">Error.</div>';
        endif;
    }

    public function run()
    {
        return Html::decode($this->message);
    }
}