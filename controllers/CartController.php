<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Product;
use Yii;
use app\models\Cart;
use app\models\search\CartSearch;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionMake()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $carts = [];
        $tel = $chat_id = $time = $location = null;
        $total_count = $total_cost = 0;
        $requests = \Yii::$app->request->post();

        foreach ($requests as $request){
            if (isset($request['id'])){
                $carts[] = $request;
            }
            if (isset($request[0]['phonenumber'])){
                $tel = $request[0]['phonenumber'];
                $chat_id = $request[0]['chatId'];
            }
            if (isset($request[0]['location'])){
                $location = $request[0]['location'];
            }
            if (isset($request[0]['time'])){
                $time = $request[0]['time'];
            }
        }

        foreach ($carts as $cart) {
            $total_count = $total_count + $cart['count'];
            $total_cost = $total_cost + $cart['cost'];
        }

        $order = new Orders();
        $order->order_key = strtoupper(uniqid());
        $order->client_id = $chat_id;
        $order->cost = $total_cost;
        $order->count = $total_count;
        $order->location = $location;
        $order->time = $time;
        $order->tel = $tel;
        $order->status = 1;
        $order->save();
        $error['order'][] = $order->getErrors();

        foreach ($carts as $cart) {
            $model = new Cart();
            $model->product_id = $cart['id'];
            $model->order_id = $order->id;
            $model->cost = $cart['cost'];
            $model->count = $cart['count'];
            $model->save();
            $error['cart'][] = $model->getErrors();
        }

        if (empty($error)){
            $message = 'success';
        }else{
            $message = $error;
        }

        return $message;
    }

}
