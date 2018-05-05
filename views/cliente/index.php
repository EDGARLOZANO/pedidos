<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Create Cliente',['value'=>Url::to('create'),
            'class' => 'btn btn-success', 'id'=>'modalButton']) ?>
    </p>

    <?php
        Modal::begin([
                'header'=>'<h4>Cliente</h4>',
                'id'=>'modalClienteCreate',
                'size'=>'modal-lg',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();


    ?>
    <?php
    Modal::begin([
        'header'=>'<h4>Cliente</h4>',
        'id'=>'update-modal',
        'size'=>'modal-lg'
    ]);

    echo "<div id='updateModalContent'></div>";

    Modal::end();
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'rfc',
            'razonsocial',

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 8.7%'],
                'visible'=> Yii::$app->user->isGuest ? false : true,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        $t = 'view?id='.$model->id;
                        $btn = Html::button("<span class='glyphicon glyphicon-eye-open'></span>",[
                            'value'=>Url::to($t), //<---- here is where you define the action that handles the ajax request
                            'class'=>'update-modal-click grid-action btn-xs btn btn-default',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>'Ver'
                        ]);
                        return $btn;



                    },
                    'update'=>function ($url, $model) {
                        $t = 'update?id='.$model->id;
                        $btn = Html::button("<span class='glyphicon glyphicon-pencil'></span>",[
                            'value'=>Url::to($t), //<---- here is where you define the action that handles the ajax request
                            'class'=>'update-modal-click grid-action btn-xs btn btn-default',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>'Editar'
                        ]);
                        return $btn;
                    },
                ],
            ],

        ]
    ]); ?>
</div>
