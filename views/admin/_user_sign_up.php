<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use kartik\select2\Select2;
?>
<div id="user_form_container">
    <?php $userForm = ActiveForm::begin([
        'id' => 'user-form',
        'action' => \yii\helpers\Url::to(['/user/create']),
    ]); ?>
    <?= $userForm->field($model, 'first_name')->label(Yii::t('app', 'First Name'))->textInput()?>
    <?= $userForm->field($model, 'last_name')->label(Yii::t('app', 'Last Name'))->textInput()?>
    <?= $userForm->field($model, 'username')->label(Yii::t('app', 'Username'))->textInput()?>
    <?= $userForm->field($model, 'password')->label(Yii::t('app', 'Password'))->passwordInput()?>
    <?= $userForm->field($model, 'password_repeat')->label(Yii::t('app', 'Retype Your Password'))->passwordInput()?>
    <?= Html::submitButton('<span class="fa fa-upload" aria-hidden="true"></span> ' . Yii::t('app', 'Save'), [
        'class'             => 'btn btn-success',
    ])?>
    <?php $customerForm = ActiveForm::end() ?>
</div>