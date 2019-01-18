<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\gallery\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCssFile(\Yii::getAlias('@web').'/css/masonry.css');

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
<?php \yii2masonry\yii2masonry::begin([
    'clientOptions' => [
        'columnWidth' => 50,
        'itemSelector' => '.item'
    ]
]); ?>
    
    <?php
/*        print_r($pictureSet);
        die();*/
        foreach ($pictureSet as $index => $array) 
        {
            foreach ($array as $slug => $url) 
            {
                $link = Url::to(['categories/view', 'slug' =>$slug]);
                echo Html::beginTag('div', ['class'=> 'item']);
                echo Html::beginTag('a', ['href'=> $link]);
                echo Html::img($url, ['width'=> 200, 'height'=>200]);
                echo Html::endTag('a');
                echo Html::endTag('div');
            }
        }



      ?>


 <!--        <div class="item" ><img src="https://i.redd.it/spo5q1n66gg11.jpg"height="200" width="200"></div>
 <div class="item"><img src="https://i.redd.it/spo5q1n66gg11.jpg"height="200" width="200"></div>
 <div class="item"><img src="https://i.redd.it/spo5q1n66gg11.jpg"height="200" width="200"></div>
 <div class="item"><img src="https://i.redd.it/spo5q1n66gg11.jpg"height="200" width="200"></div> -->


<?php \yii2masonry\yii2masonry::end(); ?>