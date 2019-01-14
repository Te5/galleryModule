<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\common\modules\gallery\models\Pictures */

$this->title = 'Upload an image';
$this->params['breadcrumbs'][] = ['label' => 'Pictures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pictures-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
