<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\web\jQuery;

/* @var $this yii\web\View */
/* @var $model common\modules\gallery\models\Categories */

$this->title = $model->cat_name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//baguettebox is reinitiated in scrypt as well
$this->registerJs('baguetteBox.run(".gallery");');
?>

<div class="categories-view" align="center">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<?php 
            if(!\Yii::$app->user->isGuest and \Yii::$app->user->identity->username == 'admin')
        {
         echo Html::a('Manage category', ['update', 'slug' => $model->slug], ['class' => 'btn btn-success']);
         echo Html::a('Delete category', ['delete', 'slug' => $model->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
                
                ],
            ]); 
            echo Html::tag('p');
            echo Html::a('Upload a picture', [Url::to('pictures/create')], ['class' => 'btn btn-success']);
            echo Html::endTag('p');         
        }

 ?>        

    </p>

<?php



echo Html::beginTag('div', ['class'=> 'gallery container', 'id' => 'gallery']);
\shiyang\masonry\Masonry::begin([
        'options' => [
          'id' => 'models',
          'columnWidth' => '0',
        ],
        'pagination' => $pages
    ]);

    foreach ($models as $model) 
    {

        $url = $model->getPictureUrl($model);
        $img = Html::img($url);
        echo Html::beginTag('div', ['class'=> 'grid-item']);
        echo Html::beginTag('a', ['href'=> $url, 'data-caption'=> $model->pic_heading]);
        echo $img;
        echo Html::endTag('a');
        echo Html::endTag('div');
    }
\shiyang\masonry\Masonry::end();
    echo Html::endTag('div');

?> 
