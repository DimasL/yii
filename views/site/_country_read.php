<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\DetailView;
use \webvimark\modules\UserManagement\models\User;

$this->title = 'Country';
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['indexcountry']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= User::canRoute('/site/updatecountry') ? Html::a('Update', ['updatecountry', 'id' => $model->id], ['class' => 'btn btn-primary']) : null ?>
        <?= User::canRoute('/site/updatecountry') ? Html::a('Delete', ['deletecountry', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) : null ?>
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
