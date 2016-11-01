<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \webvimark\modules\UserManagement\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',
            'price',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        return User::canRoute('/site/readproduct/' . $model->id) ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'readproduct/' . $model->id, [
                            'title' => Yii::t('yii', 'Read'),
                        ]) : null;

                    },
                    'update' => function ($url, $model) {
                        return User::canRoute('updateproduct/' . $model->id) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'updateproduct/' . $model->id, [
                            'title' => Yii::t('yii', 'Update'),
                        ]) : null;

                    },
                    'delete' => function ($url, $model) {
                        return User::canRoute('deleteproduct/' . $model->id) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', 'deleteproduct/' . $model->id, [
                            'title' => Yii::t('yii', 'Update'),
                        ]) : null;

                    },
                ]
            ],
        ],
    ]); ?>
</div>
