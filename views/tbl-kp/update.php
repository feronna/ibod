<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\kontrak\TblKp */
?><div class="col-md-12">
    <?php echo $this->render('/kontrak/_menu');?> 
</div><?php
$this->title = $model->department->fullname;
?>
<div class="tbl-kp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="tbl-kp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kp')->textInput(['maxlength' => true])->label('Nama Ketua Pentadbiran') ->widget(Select2::classname(), [
                                'data' => yii\helpers\ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => '1'])->all(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => 'Sila pilih nama', 'default' => 0],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                               
                            ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
