<?php

namespace common\modules\gallery\controllers;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `gallery` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdmin()
    {
        if(Yii::$app->user->isGuest or Yii::$app->user->identity->username != 'admin')
        {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        } else 
        {
        	return $this->render('admin');
        }    	
    }
}
