<?php

namespace common\modules\gallery\controllers;

use Yii;
use common\modules\gallery\models\Pictures;
use common\modules\gallery\models\Categories;
use common\modules\gallery\models\PicturesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;
/**
 * PicturesController implements the CRUD actions for Pictures model.
 */
class PicturesController extends Controller
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
     * Lists all Pictures models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PicturesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pictures model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $url = $model->getPictureUrl($model);
        return $this->render('view', [
            'model' => $model,
            'url' => $url,
        ]);
    }

    /**
     * Creates a new Pictures model.
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
            $model = new Pictures();
            $categories = new Categories();

            if ($model->load(Yii::$app->request->post()) && $model->validate())
            {

                $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
                $model->extension = $model->fileImage->extension;
                $model->save();
                if ($model->fileImage)
                {
                    $url = Url::to('@images/' . $model->pic_category . '/'.$model->id . '.' . $model->fileImage->extension);
                    $model->fileImage->saveAs($url);
                }
                $model->upload_date = new \yii\db\Expression('NOW()');

                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Updates an existing Pictures model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = new Categories();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Pictures model.
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
     * Finds the Pictures model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pictures the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pictures::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
