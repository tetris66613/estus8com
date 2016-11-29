<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'amount') ?>
<?= Html::submitButton('Refill', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
