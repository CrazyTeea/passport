<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container off">

    <p>Заполните поля для входа:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="row">

        <div class="col-2">
            <div class="float-left">
                <?= $form->field($model, 'rememberMe',['options'=>['class'=>'ml-3 mt-2']])->checkbox(['template'=>"<div class='custom-checkbox'>{input}\n{label}</div>"]) ?>
            </div>

        </div>

        <div class="col-2">
            <?= Html::submitButton('Войти', ['class' => 'float-right btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>
