<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \webvimark\modules\UserManagement\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCountry */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Countries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= User::canRoute('/site/createcountry') ? Html::a('Create Country', ['createcountry'], ['class' => 'btn btn-success']) : null ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'slug',
            'sort_order',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{update}{delete}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        return User::canRoute('/site/readcountry/' . $model->id) ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'readcountry/' . $model->id, [
                            'title' => Yii::t('yii', 'Read'),
                        ]) : null;

                    },
                    'update' => function ($url, $model) {
                        return User::canRoute('updatecountry/' . $model->id) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'updatecountry/' . $model->id, [
                            'title' => Yii::t('yii', 'Update'),
                        ]) : null;

                    },
                    'delete' => function ($url, $model) {
                        return User::canRoute('deletecountry/' . $model->id) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', 'deletecountry/' . $model->id, [
                            'title' => Yii::t('yii', 'Update'),
                        ]) : null;

                    },
                ]
            ],
        ]
    ]); ?>
</div>
