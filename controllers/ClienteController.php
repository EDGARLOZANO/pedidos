<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use app\models\ClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuarios;
use yii\filters\AccessControl;



/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
        'access' => [
        'class' => AccessControl::className(),
        'only' => [ 'index','view','create','update','delete'],
        'rules' => [
            [
                //El administrador tiene permisos sobre las siguientes acciones
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
                    return Usuarios::isUserAdmin(Yii::$app->user->identity->username);
                },
            ],
            [
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
     * Lists all Cliente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cliente model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $transaction = Cliente::getDb()->beginTransaction();
        try {

            $model = new Cliente();


            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'message' => 'Guardado con exito!',
                    'title' => '    Cliente',
                    'positonY' => 'top',
                    'positonX' => 'right'
                ]);


                $transaction->commit();



                return $this->redirect(['index']);
            }

        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;

        }


        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->getSession()->setFlash('warning', [
                'type' => 'warning',
                'duration' => 3000,
                'icon' => 'glyphicon glyphicon-ok-sign',
                'message' => 'Modificado con exito!',
                'title' => '   Cliente',
                'positonY' => 'top',
                'positonX' => 'right'
            ]);


            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cliente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $transaction = Cliente::getDb()->beginTransaction();
        try {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('danger', [
            'type' => 'danger',
            'duration' => 3000,
            'icon' => 'glyphicon glyphicon-ok-sign',
            'message' => 'Fue eliminado!',
            'title' => '   Cliente',
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
            $transaction->commit();

        }
        catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;

        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
