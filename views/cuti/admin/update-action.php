<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\hronline\Campus;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
?>
<div class="align-center text-center title bg-success" style="padding: 1px">
    <h4><i class="fa fa-user"></i>&nbsp;Update Access</h4>
</div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>



<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Officer that Will Verify
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
    <?=
            $form->field($model, 'icno_pemberi_kuasa')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=','Status','6'])->all(), 'ICNO', 'CONm'),
                'options' => ['placeholder' => 'Choose JSPIU', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?> 
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">On Behalf of Officer
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan Kelulusan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
            $form->field($model, 'icno_tindakan')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=','Status','6'])->all(), 'ICNO', 'CONm'),
                'options' => ['placeholder' => 'Choose JSPIU', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?> </div>

</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan Kelulusan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
            $form->field($model, 'catatan')->textArea()->label(false);
            ?> </div>

</div>


<div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>