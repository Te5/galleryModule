<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>


<?php 

        $url = $model->getPictureUrl($model);
        $img = Html::img($url, ['width'=>200, 'height'=>200]);
        echo Html::beginTag('div', ['class'=> 'grid-item']);
        echo Html::beginTag('a', ['href'=> $url, 'data-caption'=> $model->pic_heading]);
        echo $img;
        echo Html::endTag('a');
        echo Html::endTag('div');

 ?>