<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Producto;
use app\models\Pedido;
use app\models\Cliente;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Detallepedido */
/* @var $model2 app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallepedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'precio')->textInput() ?>
    <?php
    $items2 = ArrayHelper::map(Pedido::find()->max(1), 'id','id');
    ?>

    <?= $form->field($model, 'pedidoid')->
    dropDownList($items2,['Escoger'=>"Seleciona producto"])?>

    <?php
    $items = ArrayHelper::map(Producto::find()->all(), 'id','nombre');
    ?>

    <?= $form->field($model, 'productoid')->
    dropDownList($items,['Escoge'=>"Seleciona producto"]) ?>

    <?php
    $items2 = ArrayHelper::map(Cliente::find()->all(), 'id','rfc');
    ?>






    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
