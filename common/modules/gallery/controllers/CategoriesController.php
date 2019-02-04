<?php

namespace common\modules\gallery\controllers;

use Yii;
use yii\data\Pagination;
use common\modules\gallery\models\Categories;
use common\modules\gallery\models\CategoriesSearch;
use common\modules\gallery\models\PicturesSearch;
use common\modules\gallery\models\Pictures;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;
use yii\data\ActiveDataProvider; 
use yii\helpers\ArrayHelper;
/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
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
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $pictureSet = Categories::getLatestPictures();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pictureSet'=> $pictureSet,
        ]);
    }

    /**
     * Displays a single Categories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {

        $searchModel = new PicturesSearch();
        $model = Categories::findOne(['slug'=>$slug]);
        $query = Pictures::find()->where(['pic_category'=>$model->cat_name]);
        $countQuery = clone $query; 
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();


        
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'models' => $models,
            'pages' => $pages,
        ]);
    }
    public function actionViewalt($slug)
    {

        $searchModel = new PicturesSearch();
        $model = Categories::findOne(['slug'=>$slug]);
        $query = Pictures::find()->where(['pic_category'=>$model->cat_name]);
        $countQuery = clone $query; 
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();


        
        return $this->render('alt_view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'models' => $models,
            'pages' => $pages,
            'dataProvider' => $query,
        ]);
    }
    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->isGuest or Yii::$app->user->identity->username != 'admin')
        {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        } else 
        {
            $model = new Categories();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $dir = Url::to('@images/'.$model->slug);
                mkdir($dir);
                return $this->redirect(['view', 'slug' => $model->slug]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
            }            
        }        


    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        if(Yii::$app->user->isGuest or Yii::$app->user->identity->username != 'admin')
        {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        } else 
        {
            $model = $this->findModel(['slug' => $slug]);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'slug' => $model->slug]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);                
        }        

    }

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        if(Yii::$app->user->isGuest or Yii::$app->user->identity->username != 'admin')
        {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        } else 
        {
            $model = $this->findModel($slug);
            $model->scenario = Categories::SCENARIO_DELETE;  
            //searchmodel is to be presented with category options if admin decides to move all the pics after deletion              
            $searchModel = new CategoriesSearch();
            $categoriesArray = ArrayHelper::map($searchModel::find()->all(), 'cat_name', 'cat_name');
            unset($categoriesArray[$model->cat_name]); //delete current category from the list
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                $model->categoryDeletionHandler($model->adminDeletionChoice, $model->cat_name, $model->categoryToReceiveImages);
                        
                \Yii::$app->getSession()->setFlash('success', 'Category deleted');
                return Yii::$app->getResponse()->redirect(['gallery/categories']);        
                echo Yii::$app->session->getFlash('success');                
            }
            

            return $this->render('cat_delete', [
                'model' => $model,
                'categoriesArray' => $categoriesArray,
            ]);              
        }
      
    }

    public function actionManage() 
    {
        if(Yii::$app->user->isGuest or Yii::$app->user->identity->username != 'admin')
        {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        } else   
        {
            $searchModel = new CategoriesSearch(); 
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 

            return $this->render('manage', [ 
                'searchModel' => $searchModel, 
                'dataProvider' => $dataProvider, 
            ]);             
        }   

    } 

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Categories::findOne(['slug'=>$slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
