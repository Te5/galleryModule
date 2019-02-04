<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Admin panel';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Welcome, admin</h2>

<p class="btn btn-success">
<?= Html::a('Manage categories', Url::to(['categories/manage'], ))?>     
</p>
<p class="btn  btn-success">
<?= Html::a('Manage pictures', Url::to(['pictures/index'], ))?>     
</p>

</div>
</div>
