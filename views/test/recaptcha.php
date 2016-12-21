<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->registerJsFile('https://www.google.com/recaptcha/api.js', ['position' => \yii\web\View::POS_HEAD]);

$this->title = 'Recaptcha';

?>
<?php $form = ActiveForm::begin() ?>
<div class="g-recaptcha" data-sitekey="6Lcidw8UAAAAACxFtQsBP6JS9Blo2fl2Ca0SY1OT"></div>
<?=  Html::submitButton('test', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
