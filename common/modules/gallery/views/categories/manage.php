<?php

use yii\helpers\Html; 
use yii\grid\GridView; 
use yii\helpers\Url;
/* @var $this yii\web\View */ 
/* @var $searchModel common\modules\gallery\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */ 

$this->title = 'Categories'; 
$this->params['breadcrumbs'][] = $this->title; 
?> 
<div class="categories-index"> 

    <h1><?= Html::encode($this->title) ?></h1> 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 

    <p> 
        <?= Html::a('Create Categories', ['create'], ['class' => 'btn btn-success']) ?> 
    </p> 

    <?= GridView::widget([ 
        'dataProvider' => $dataProvider, 
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 

            'id',
            'cat_name',
            'slug',
            'status',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}','urlCreator' => function ($action, $model, $key, $index) {
                        if($action == 'view') 
                        {
                            return Url::to(['categories/view', 'slug'=>$model->slug]);
                        } else 
                        {
                            return Url::to(['categories/'.$action, 'slug'=>$model->slug]);
                        }
            
                        }
                ], 
        ], 
    ]); ?> 
</div> 