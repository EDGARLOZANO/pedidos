<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\models\Cliente;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>



    <?php

    $items = ArrayHelper::map(Cliente::find()->all(), 'id','rfc');
    ?>



    <?php echo $form->field($model, 'clienteid')->
    dropDownList($items,['Escoge'=>"Seleciona cliente"]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
