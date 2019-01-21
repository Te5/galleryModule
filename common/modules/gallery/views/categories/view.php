<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

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

<?php
 \yii2masonry\yii2masonry::begin([
    'clientOptions' => [
        'columnWidth' => 30,
        'itemSelector' => '.gallery'
    ]
    ]); 
    echo Html::beginTag('div', ['class'=> 'gallery']);
    foreach ($picModels as $model) 
    {
        $url = $model->getPictureUrl($model);
        $img = Html::img($url, ['width'=>200, 'height'=>200]);
        
        echo Html::beginTag('a', ['href'=> $url, 'data-caption'=> $model->pic_heading]);
        echo $img;
        echo Html::endTag('a');

    }
    echo Html::endTag('div');

?>
<?php \yii2masonry\yii2masonry::end(); ?>


