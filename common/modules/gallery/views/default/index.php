<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Gallery module</h2>

        <p><a class="btn btn-lg btn-success" href="gallery/categories">Show categories</a></p>
<?php 
	        if(!\Yii::$app->user->isGuest and \Yii::$app->user->identity->username == 'admin')
        {

        	echo Html::a('Admin panel', Url::to(['admin'],['class' => 'btn btn-success']));

        }
 ?>
 		
    </div>


</div>
