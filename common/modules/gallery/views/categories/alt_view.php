<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\web\jQuery;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $model common\modules\gallery\models\Categories */

$this->title = $model->cat_name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJs('baguetteBox.run(".gallery");');
/*$this->registerJsFile(Yii::$app->basePath.'/web/js/myscript.js');*/
/*print_r(Yii::$app->basePath.'/web/js/myscript.js');
die();*/
?>

<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


</div>

<?php
/*print_r($pages->links);
die();*/

echo Html::beginTag('div', ['class'=> 'gallery']);  

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
echo Html::endTag('div');     
  //divs are for the selector for the paged nav  
  echo Html::beginTag('div', ['class'=> 'navigation']);  
  echo LinkPager::widget([
    'pagination' => $pages,
    ]);
  echo Html::endTag('div'); 
?> 
