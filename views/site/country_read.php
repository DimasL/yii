<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

$this->title = 'Custom Page (create country)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['updatecountry', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['deletecountry', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'slug',
            'sort_order',
        ],
    ]) ?>

</div>
