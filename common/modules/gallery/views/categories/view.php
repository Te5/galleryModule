<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $model common\modules\gallery\models\Categories */

$this->title = $model->cat_name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerJs('baguetteBox.run(".gallery");');

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

<!-- <?php

    echo Html::beginTag('div', ['class'=> 'gallery container','data-masonry'=>'{"itemSelector": ".grid-item", "columnWidth": 200 }']);
    foreach ($picModels as $model) 
    {
        $url = $model->getPictureUrl($model);
        $img = Html::img($url, ['width'=>200, 'height'=>200]);
        echo Html::beginTag('div', ['class'=> 'grid-item']);
        echo Html::beginTag('a', ['href'=> $url, 'data-caption'=> $model->pic_heading]);
        echo $img;
        echo Html::endTag('a');
        echo Html::endTag('div');

    }
    echo Html::endTag('div');



?> -->


<?php 
echo Html::beginTag('div', ['class'=> 'gallery container','data-masonry'=>'{"itemSelector": ".grid-item", "columnWidth": 200 }']);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_pictures',
]);

echo Html::endTag('div');
 ?>