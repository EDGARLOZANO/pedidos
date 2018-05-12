<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Cliente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'razonsocial')->dropDownList( ['fisica' => 'FISICA', 'moral' => 'MORAL'] ); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']);
 ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
