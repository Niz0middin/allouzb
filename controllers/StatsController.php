<?php

namespace app\controllers;

use app\models\Orders;
use app\models\search\ProductStatsSearch;
use Yii;
use app\models\Cart;
use app\models\search\CartSearch;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class StatsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all Cart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductStatsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 100];
        $dataProvider->setSort([
            'defaultOrder' => [
                'created_at' => SORT_DESC
            ]
        ]);

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

        $requests = Yii::$app->request->post();

        foreach ($requests as $request){
            if (isset($request['id'])){
                $carts[] = $request;
            }
            if (isset($request['phonenumber'])){
                $tel = $request['phonenumber'];
                $chat_id = $request['chatId'];
            }
            if (isset($request['location'])){
                $location = $request['location'];
            }
            if (isset($request['time'])){
                $time = $request['time'];
            }
        }

        foreach ($carts as $cart) {
            $total_count = $total_count + $cart['count'];
            $total_cost = $total_cost + $cart['count']*$cart['cost'];
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
            $model->cost = $cart['count']*$cart['cost'];
            $model->count = $cart['count'];
            $model->save();
            $error['cart'][] = $model->getErrors();
        }

        if (empty($error['order'] && empty($error['cart']))){
            $response = $order->toArray();
            $text = '';
            foreach ($order->carts as $c) {
                $text = $text.$c->product->name.' - '.$c->count.' шт = '.$c->cost." UZS\n";
            }
                $response['description'] = $text;
            $message = $response;
        }else{
            $message = $error;
        }

        return $message;
    }


    public function actionGetOrder($key)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $order = Orders::findOne(['order_key' => $key]);
        if (!empty($order)){
            $response = $order;
        }
        else $response = "There is no order with this key";
        return $response;
    }

    public function actionGetClientOrder($chat_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $orders = Orders::find()->where(['client_id' => $chat_id, 'status' => [1,2]])->all();
        $response = $res = [];
        if (!empty($orders)){
            foreach ($orders as $order){
                $text = '';
                foreach ($order->carts as $c) {
                    $text = $text.$c->product->name.' - '.$c->count.' шт = '.$c->cost." UZS\n";
                }
                $res = $order->toArray();
                $res['description'] = $text;
                $response[] = $res;
            }
            return $response;
        }
        else $response = "There is no order of this user";
        return $response;
    }

}
