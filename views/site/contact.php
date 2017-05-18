    <?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;



?>


<div class="col-sm-12 col-xs-12 main_box_layout">
    <div class="cat_name">
        <?= Yii::t('app','Contact Us'); ?>
    </div>
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            <?= Yii::t('app','Thank you for contacting us. We will respond to you as soon as possible.') ?>
        </div>
    <?php else: ?>
        <div class="contact_box">
            <h3 class="contact-box-text"><b>If you have business inquiries or other questions, please fill out the following
                form to contact us. Thank you.</b></h3>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'name',[
                    'template' => '<div class="col-sm-1 col-xs-12">{label}</div><div class="col-sm-11 col-xs-12">{input}</div>.'])->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email',[
                    'template' => '<div class="col-sm-1 col-xs-12">{label}</div><div class="col-sm-11 col-xs-12">{input}</div>.']) ?>
                <?= $form->field($model, 'subject',[
                    'template' => '<div class="col-sm-1 col-xs-12">{label}</div><div class="col-sm-11 col-xs-12">{input}</div>.']) ?>
                <?= $form->field($model, 'body',[
                    'template' => '<div class="col-sm-1 col-xs-12">{label}</div><div class="col-sm-11 col-xs-12">{input}</div>.'])->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3 col-sm-4">{image}</div><div class="col-lg-6 col-sm-6">{input}</div></div>',
                ]) ?>

                <div class="form-group" style="float: right; padding-right: 10px;">
                    <?= Html::submitButton('Submit', ['class' => 'contact-box-button btn custom_btn', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    <?php endif; ?>
</div>
