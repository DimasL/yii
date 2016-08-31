<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Custom Page (create country)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $form = ActiveForm::begin([
    'id' => 'country-form',
    'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'slug') ?>
    <?= $form->field($model, 'sort_order') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>

</div>
