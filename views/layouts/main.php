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

use kartik\growl\Growl;


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

                 ]
            ];
        $menuItems[]=['label' => '<span class="glyphicon glyphicon-briefcase"></span> Clientes',
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver Clientes',
                    'url' => ['/cliente/index']],


            ]];

        $menuItems[]=['label' => '<span class="glyphicon glyphicon-barcode"></span> Productos',
            'items' => [
                ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Ver Productos', 'url' => ['/producto/index']],

            ]

            ];}

        else{
            $menuItems[]=['label' => '<span class="glyphicon glyphicon-shopping-cart"></span>Pedidos',
                'items' => [
                     ['label' => '<span class="glyphicon glyphicon-eye-open"></span> Pedido', 'url' => ['/pedido/index']] ,
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
    <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
        <?php
        echo Growl::widget([
            'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
            'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
            'showSeparator' => true,
            'delay' => 1, //This delay is how long before the message shows
            'pluginOptions' => [
                'showProgressbar' => true,
                'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                'placement' => [
                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                ]
            ]
        ]);
        ?>
    <?php endforeach; ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

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
