<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;



?>


<div class="col-sm-12">
    <h1 style="border-bottom: 2px solid black; padding-bottom:20px; margin-bottom: 20px;">
        <strong>
            <center>
                Contant us
            </center>
        </strong>
    </h1>
  </div>
  <div class="site-contact">
    <div class="box-header header_height"></div>
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>
    <?php else: ?>

        <div class="row">
            <div class="contact_box col-lg-5 col-sm-7 col-xs-10">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3 col-sm-4">{image}</div><div class="col-lg-6 col-sm-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group" style="float: right;">
                        <?= Html::submitButton('Submit', ['class' => 'btn custom_btn', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
