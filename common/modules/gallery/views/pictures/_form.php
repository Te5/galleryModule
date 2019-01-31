<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\common\modules\gallery\models\Pictures */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pictures-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic_heading')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pic_category')->dropDownList(
    ArrayHelper::map($categories::find()->all(), 'cat_name', 'cat_name'), ['prompt' => 'Select Category']
  ) ?> 

    <?= $form->field($model, 'status')->label('Visibility')->dropDownList([
            0 => 'Visible for everyone',
            1 => 'Hidden',
            2 => 'For authorized users only',
            3 => 'Admin only'    ]) ?>

    <?= $form->field($model, 'fileImage')->fileInput() ?>

    <?= $form->field($model, 'watermarkPosition')->label('Watermark')->radioList([
            0 => 'Do not place',
            1 => 'Left down corner',
            2 => 'Left upper corner',
            3 => 'Right down corner',
            4 => 'Right upper corner',
                ]) ?>    
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    


    <?php ActiveForm::end(); ?>

</div>
