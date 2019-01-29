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
        echo Html::beginTag('div', ['class'=> 'container','data-masonry'=>'{"itemSelector": ".category-item", "columnWidth": 0 }' ]);
/*        print_r($pictureSet);
        die();*/
        foreach ($pictureSet as $category) 
        {   
/*                print_r($category);
                die();*/
                $link = Url::to(['categories/view', 'slug' =>$category['slug']]);
                
                echo Html::beginTag('div', ['class'=> 'category-item']);
                echo Html::beginTag('a', ['href'=> $link]);            
                echo Html::img($category['url']);
                echo Html::endTag('a');
                echo Html::beginTag('div', ['class'=> 'content']);
                echo Html::tag('p', $category['cat_name'] .' ('.$category['records'].')');
                echo Html::endTag('div');
                echo Html::endTag('div');
                
            
        }
        echo Html::endTag('div');


      ?>