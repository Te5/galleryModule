<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\gallery\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category">


	<h1>Category delete form</h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'adminDeletionChoice')->label('What to do with the image files of this category?')->radioList([
            0 => 'Move to another category',
            1 => 'Delete them',
                ]) ?>


    <?= $form->field($model, 'categoryToReceiveImages')->label('Which one?')->dropDownList($categoriesArray, ['prompt' => 'Select Category',]) ?>		
             


    <div class="form-group">
        <?= Html::submitButton('Delete', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
