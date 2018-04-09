<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Detallepedido */

$this->title = 'Create Detallepedido';
$this->params['breadcrumbs'][] = ['label' => 'Detallepedidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detallepedido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
