<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DetallePedidoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detallepedido-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cantidad') ?>

    <?= $form->field($model, 'precio') ?>

    <?= $form->field($model, 'pedidoid') ?>

    <?= $form->field($model, 'productoid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
