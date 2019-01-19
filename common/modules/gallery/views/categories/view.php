<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\modules\gallery\models\Categories */

$this->title = $model->id;
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

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        'id',
        'pic_heading',
        // ...
        ],
    ]); ?>

</div>
<?php
$pictureUrl = \Yii::getAlias('@web').'/images/undefined.jpg';


?>
<script>baguetteBox.run('.gallery');</script>
<div class="gallery">
    <a href="<?=$pictureUrl?>" data-caption="Image caption">
        <img src="<?=$pictureUrl?>" alt="First image">
    </a>
    <a href="<?=$pictureUrl?>">
        <img src="<?=$pictureUrl?>" alt="Second image">
    </a>
</div>

