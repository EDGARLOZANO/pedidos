<?php

namespace app\controllers;


use app\models\Producto;
use Yii;
use app\models\Pedido;
use app\models\Model;
use app\models\Detallepedido;
use app\models\DetallePedidoSearch;
use app\models\PedidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuarios;
use yii\filters\AccessControl;
use \yii\helpers\ArrayHelper;




/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {return ['access' => [
        'class' => AccessControl::className(),
        'only' => [ 'index','view','create','update','delete'],
        'rules' => [
            [
                //El administrador tiene permisos sobre las siguientes acciones
                'actions' => ['index','view','create','update','delete'
                ],
                //Esta propiedad establece que tiene permisos
                'allow' => false,
                //Usuarios autenticados, el signo ? es para invitados
                'roles' => ['@'],
                //Este método nos permite crear un filtro sobre la identidad del usuario
                //y así establecer si tiene permisos o no
                'matchCallback' => function ($rule, $action) {
                    //Llamada al método que comprueba si es un administrador
                    return Usuarios::isUserAdmin(Yii::$app->user->identity->username);
                },
            ],
            [
                'actions' => ['index','view','create','update','delete'
                ],
                //Esta propiedad establece que tiene permisos
                'allow' => true,
                //Usuarios autenticados, el signo ? es para invitados
                'roles' => ['@'],
                //Este método nos permite crear un filtro sobre la identidad del usuario
                //y así establecer si tiene permisos o no
                'matchCallback' => function ($rule, $action) {
                    //Llamada al método que comprueba si es un administrador
                    return Usuarios::isUserSimple(Yii::$app->user->identity->username);
                },
            ],
            [
                'actions' => ['index','view','create','update','delete'
                ],
                //Esta propiedad establece que tiene permisos
                'allow' => false,
                //Usuarios autenticados, el signo ? es para invitados
                'roles' => ['?'],
                //Este método nos permite crear un filtro sobre la identidad del usuario
                //y así establecer si tiene permisos o no
                'matchCallback' => function ($rule, $action) {
                    //Llamada al método que comprueba si es un administrador

                },
            ],
        ],
    ],

        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ],
    ];
    }

    /**
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PedidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pedido model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new DetallePedidoSearch();

        $dataProvider = $searchModel->search([$searchModel->pedidoid=$id]);

        return $this->renderAjax('/detalle-pedido/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {


        $model = new Pedido();
        $detalle = [new Detallepedido];

        $model->fecha = date("d/m/Y");


        if ($model->load(Yii::$app->request->post())  ) {



            $model->save();


            $detalle= Model::createMultiple(Detallepedido::classname());
            Model::loadMultiple($detalle, Yii::$app->request->post());
            foreach ($detalle as $detalle) {
                $detalle->pedidoid = $model->id;
                
                $detalle->save();
            }


            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => 'Guardado con exito!',
                'title' => '    Pedido',
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
            return $this->redirect(['index']);

        }

        return $this->renderAjax('create', [
            'model' => $model,
            'detalle' =>(empty($detalle)) ? [new Detallepedido()] : $detalle
        ]);
    }





    /**
     * Updates an existing Pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

            $model = $this->findModel($id);
            $detalle = $model->detallepedidos;

            if ($model->load(Yii::$app->request->post())) {

                $oldIDs = ArrayHelper::map($detalle, 'id', 'id');
                $detalle= Model::createMultiple(Detallepedido::classname(), $detalle);
                Model::loadMultiple($detalle, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($detalle, 'id', 'id')));

                 $model->save();
                if (! empty($deletedIDs)) {
                    Detallepedido::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($detalle as $detalle) {
                    $detalle->pedidoid= $model->id;
                     $detalle->save();
                    }
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'info',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-sort',
                    'message' => 'Actualizado con exito!',
                    'title' => '    Pedido',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);
                return $this->redirect(['index']);

            }

        return $this->renderAjax('update', [
            'model' => $model,
            'detalle' =>(empty($detalle)) ? [new Detallepedido] : $detalle
        ]);
    }

    /**
     * Deletes an existing Pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $detalle = $model->detallepedidos;

        $oldIDs = ArrayHelper::map($detalle, 'id', 'id');
        $detalle= Model::createMultiple(Detallepedido::classname(), $detalle);
        Model::loadMultiple($detalle, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($detalle, 'id', 'id')));

        Detallepedido::deleteAll(['id' => $deletedIDs]);

        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', [
            'type' => 'danger',
            'duration' => 3000,
            'icon' => 'glyphicon glyphicon-remove',
            'message' => 'Fue eliminado!',
            'title' => '    Pedido',
            'positonY' => 'top',
            'positonX' => 'right'
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
