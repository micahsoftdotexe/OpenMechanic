<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<div id="user_form_container">
    <?php $userForm = ActiveForm::begin([
        'id' => 'user-form',
        'action' => $edit?\yii\helpers\Url::to(['/user/edit', 'id' => $model->id]):\yii\helpers\Url::to(['/user/create']),
    ]); ?>
    <?= $userForm->field($model, 'first_name')->label(Yii::t('app', 'First Name'))->textInput()?>
    <?= $userForm->field($model, 'last_name')->label(Yii::t('app', 'Last Name'))->textInput()?>
    <?= $userForm->field($model, 'username')->label(Yii::t('app', 'Username'))->textInput()?>
    <?= $userForm->field($model, 'password')->label(Yii::t('app', 'Password'))->passwordInput()?>
    <?= $userForm->field($model, 'password_repeat')->label(Yii::t('app', 'Retype Your Password'))->passwordInput()?>
    <?php if ($edit && $model->id != Yii::$app->user->id) : ?>
        <?= $userForm->field($model, 'roles')->label(Yii::t('app', 'Roles'))->widget(Select2::class, [
            'data' => $model->getRoles(),
            'options' => ['placeholder' => Yii::t('app', 'Select user roles ...'), 'multiple' => true],
        ]);?> 
    <?php endif; ?>
    <?= Html::submitButton('<span class="fa" aria-hidden="true"></span> ' . Yii::t('app', 'Save'), [
        'class'             => 'btn btn-success',
    ])?>
    <?php $customerForm = ActiveForm::end() ?>
</div>