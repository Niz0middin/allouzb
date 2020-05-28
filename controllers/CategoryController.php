<?php

namespace app\controllers;

use app\models\Product;
use Yii;
use app\models\Category;
use app\models\search\CategorySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 100];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ( ! empty(Yii::$app->request->post('Category')))
        {
            $post            = Yii::$app->request->post('Category');
            $model->name     = $post['name'];
            $model->position = $post['position'];
            $parent_id       = $post['parentId'];

            if (empty($parent_id))
                $model->makeRoot();
            else
            {
                $parent = Category::findOne($parent_id);
                $model->appendTo($parent);
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( ! empty(Yii::$app->request->post('Category')))
        {
            $post            = Yii::$app->request->post('Category');

            $model->name     = $post['name'];
            $model->position = $post['position'];
            $parent_id       = $post['parentId'];

            if ($model->save())
            {
                if (empty($parent_id))
                {
                    if ( ! $model->isRoot())
                        $model->makeRoot();
                }
                else // move node to other root
                {
                    if ($model->id != $parent_id)
                    {
                        $parent = Category::findOne($parent_id);
                        $model->appendTo($parent);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

//        if ($model->isRoot())
//            $model->deleteWithChildren();
//        else
//            $model->delete();

        if ($model->children(1)->one() || $model->products)
            throw new NotFoundHttpException('Вы не можете удалить эту категорию. У категории есть сабкатегория или товар.');
        elseif ($model->isRoot())
            $model->deleteWithChildren();
        else
            $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGet($id=null){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($id == 0 || $id == null) {
            $response = Category::find()->roots()->all();
            $parent = null;
        }elseif ($id == 'all'){
            $response = Category::find()->all();
            $parent = null;
        }
        else{
            $response = Category::findOne(['id' => $id]);
            if (!empty($response)) {
                $parent = $response->parents(1)->one();
                $response = $response->children(1)->all();
            }else{
                $response = null;
                $parent = null;
            }
        }

        if (!empty($response)){
            $array['status'] = 0;
            $array['parent'] = $parent->id;
            foreach ($response as $key => $r) {
                $array['data'][$key] = [
                    'text' => $r->name,
                    'callback_data' => $r->id
                ];
            }
        }else{
            $response = Product::findAll(['category_id' => $id, 'status' => 1]);
            if (!empty($response)) {
                $array['parent'] = $parent->id;
                $array['data'] = $response;
                $array['status'] = 1;
            }else{
                $array['parent'] = $parent->id;
                $array['data'] = null;
                $array['status'] = 2;
            }
        }

        return $array;
    }
}
