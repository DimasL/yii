<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\FlashMessageWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-top',
        ],
    ]);

    echo \webvimark\modules\UserManagement\components\GhostNav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'activateParents' => true,

        'items' => [
            ['label' => 'Backend routes', 'items' => \webvimark\modules\UserManagement\UserManagementModule::menuItems()],
            [
                'label' => 'User Menu',
                'items' => [
                    Yii::$app->user->isGuest ? (
                        ['label' => 'Login', 'url' => ['/user-management/auth/login']]
                    ) : (
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/user-management/auth/logout']]
                    ),
                    Yii::$app->user->isGuest ? (
                        ['label' => 'Registration', 'url' => ['/user-management/auth/registration']]
                    ) : (
                        ''
                    ),
                    ['label' => 'Change own password', 'url' => ['/user-management/auth/change-own-password']],
                    ['label' => 'Password recovery', 'url' => ['/user-management/auth/password-recovery']],
                    ['label' => 'E-mail confirmation', 'url' => ['/user-management/auth/confirm-email']]
                ],
            ],
        ],

    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => 'Site Menu',
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'About', 'url' => ['/site/about']],
                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => 'Countries', 'url' => ['/site/indexcountry']],
                    ['label' => 'Products', 'url' => ['/site/indexproduct']],
                ]
            ]
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= FlashMessageWidget::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        Footer
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
