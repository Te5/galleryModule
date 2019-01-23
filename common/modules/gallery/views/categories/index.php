<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\gallery\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Photogallery';
$this->params['breadcrumbs'][] = $this->title;


\frontend\assets\AppAsset::register($this);
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?php
    if(!Yii::$app->user->isGuest and Yii::$app->user->identity->username === 'admin') 
    {
        echo Html::a('Create a category', ['create'], ['class' => 'btn btn-success']);
        echo Html::a('Submit a picture', [Url::to('pictures/create')], ['class' => 'btn btn-success']);   
    }        

    ?>
    </p>

</div>

    <?php
        echo Html::beginTag('div', ['class'=> 'container','data-masonry'=>'{"itemSelector": ".grid-item", "columnWidth": 200 }' ]);
        foreach ($pictureSet as $index => $array) 
        {
            foreach ($array as $slug => $url) 
            {
                $link = Url::to(['categories/view', 'slug' =>$slug]);
                
                echo Html::beginTag('div', ['class'=> 'grid-item']);
                echo Html::beginTag('a', ['href'=> $link]);
                echo Html::img($url, ['width'=>200]);
                echo Html::endTag('a');
                echo Html::endTag('div');
                
            }
        }
        echo Html::endTag('div');


      ?>