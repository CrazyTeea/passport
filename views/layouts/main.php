<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\models\User;
use app\widgets\Alert;
use app\widgets\NavBar;
use mdm\admin\components\MenuHelper;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\helpers\Json;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
    <?php $this->head() ?>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <script>
        window.Permission = <?= Json::encode(User::getRole(Yii::$app->user->id)) ?>;
        window.isLogin = <?=$this->context->action->id == 'login' || $this->context->id == 'assignment' ? 'true' : 'false' ?>;
    </script>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="header">
        <?php NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => 'https://xn--80apneeq.xn--p1ai/',
            'brandImage' => '/img/light-logo.svg',
            'options' => [
                'class' => 'navbar-expand-lg navbar-dark bg-dark',
            ],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'items' => array_merge([['label' => 'Инструкция', 'url' => Yii::$app->user->can('root') ? '/manual2.pdf' : '/manual.pdf']], MenuHelper::getAssignedMenu(Yii::$app->user->id))


        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav '],
            'items' => [
                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn nav-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
        NavBar::end();
        ?>
    </div>


    <div id="wrap" class="container-fluid">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer d-flex justify-content-between">

        <div class="w-auto mt-2"></div>
        <p class="text-center mt-2 mr-2">ИАС "Мониторинг"</p>
        <p class="text-center mt-2 ml-2">
            Тех. поддержка: 8-495-989-84-47 (многоканальный), 8-964-527-30-83, 8-968-758-08-94
        </p>
        <div class="w-auto mt-2"></div>



</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
