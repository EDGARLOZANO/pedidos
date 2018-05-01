<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Carousel;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

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
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<span class="glyphicon glyphicon-oil"></span> Electronics Lozano',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '<span class="glyphicon glyphicon-home"></span>  Home', 'url' => ['/site/index']],
        ['label' => '<span class="glyphicon glyphicon-info-sign"></span> About', 'url' => ['/site/about']],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-log-in"></span> Login', 'url' => ['/site/login']];
    } else {
        if(User::isUserAdmin(''.Yii::$app->user->identity->username.'')){
        $menuItems[]=['label' => '<span class="glyphicon glyphicon-user"></span> Usuarios',
            'items' => [
                     ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver usuarios', 'url' => ['/usuarios/index']],
                     ['label' => '<span class="glyphicon glyphicon-plus"></span> Crear usuario', 'url' => ['/usuarios/create']] ,
                 ]
            ];
        $menuItems[]=['label' => '<span class="glyphicon glyphicon-briefcase"></span> Clientes',
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver Clientes',
                    'url' => ['/cliente/index']],
                ['label' => '<span class="glyphicon glyphicon-plus"></span> Crear Cliente', 'url' => ['/cliente/create']] ,

            ]];

        $menuItems[]=['label' => '<span class="glyphicon glyphicon-barcode"></span> Productos',
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver Productos', 'url' => ['/producto/index']],
                ['label' => '<span class="glyphicon glyphicon-plus"></span> Crear Producto', 'url' => ['/producto/create']] ,

            ]

            ];}

        else{
            $menuItems[]=['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>Pedidos',
                'items' => [
                     ['label' => '<span class="glyphicon glyphicon-plus"></span> Crear pedido', 'url' => ['/pedido/create']],
                     ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver pedido', 'url' => ['/pedido/index']] ,
                 ]];
            $menuItems[]=['label' => '<span class="glyphicon glyphicon-hand-down"></span> Detalle Pedidos',
                'items' => [
                    ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver Detalle Pedido', 'url' => ['/detalle-pedido/index']],
                ]];
        }

        $menuItems[] = [
            'label' => '<span class="glyphicon glyphicon-log-out"></span> Logout (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];


    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
   </div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Edgar Lozano <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
