<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use app\models\Cliente;
use app\models\Producto;
use app\models\Pedido;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>


    <?php
    $items = ArrayHelper::map(Cliente::find()->all(), 'id','rfc');
    ?>


    <?php echo $form->field($model, 'clienteid')->
    dropDownList($items,['Escoge'=>"Seleciona cliente"]) ?>

    <!--Detalle Pedido -->






    <?php
    $items = ArrayHelper::map(Producto::find()->all(), 'id','nombre');
    ?>



    <?php
    $items2 = ArrayHelper::map(Cliente::find()->all(), 'id','rfc');
    ?>
    <!--wiget-->

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i>Agregar producto</h4></div>
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 99, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $detalle[0],
                        'formId' => 'dynamic-form',
                        'formFields' =>[
                               'pedidoid',
                            'cantidad',
                            'precio',
                            'productoid'
                        ],
                    ]); ?>

                    <div class="container-items"><!-- widgetContainer -->
                        <?php foreach ($detalle as $i => $detalle): ?>
                            <div class="item panel panel-default"><!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Producto</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    // necessary for update action.
                                    if (! $detalle->isNewRecord) {
                                        echo Html::activeHiddenInput($detalle, "[{$i}]id");
                                    }
                                    ?>
                                    <?= $form->field($detalle, "[{$i}]productoid")->
                                    dropDownList($items,['Escoge'=>"Seleciona producto"]) ?>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?= $form->field($detalle, "[{$i}]cantidad")->textInput() ?>

                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($detalle, "[{$i}]precio")->textInput() ?>
                                        </div>
                                    </div><!-- .row -->

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div><!-- .panel -->
                    <?php DynamicFormWidget::end(); ?>

            </div>












    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

    </div>




    <?php ActiveForm::end(); ?>

</div>
