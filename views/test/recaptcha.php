<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

//$this->registerJsFile('https://www.google.com/recaptcha/api.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Recaptcha';

?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'testfield') ?>
<?= $form->field($model, 'testrecaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
<?=  Html::submitButton('test', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
