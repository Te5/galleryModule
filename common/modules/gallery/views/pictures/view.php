<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\common\modules\gallery\models\Pictures */

$this->title = $model->pic_heading;
$this->params['breadcrumbs'][] = ['label' => 'Pictures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pictures-view">

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

<!--     <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'author',
        'pic_heading',
        'pic_category',
        'upload_date',
        'status:ntext',
    ],
]) ?> -->
    <?php
/*    print_r($url);
    die();*/
     ?>
     <img height="200" width="200" src="<?= $url ?>">
</div>
