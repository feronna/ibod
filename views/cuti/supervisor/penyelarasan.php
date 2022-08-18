<?php

use app\models\cuti\Layak;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\hronline\GredJawatan;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblOpenpos */
//
//$this->title = 'Create Tbl Openpos';
//$this->params['breadcrumbs'][] = ['label' => 'Tbl Openpos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>


<!--list permohonanan yang telah dibuka-->

<div class="col-md-12">
    <div class="x_panel">
        <?php echo Yii::$app->controller->renderPartial('_staff_details', ['biodata' => $biodata,]); ?>

        <div class="x_title">
            <h2>Penyelarasan Cuti</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah GCR Terkumpul<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="
    <?= Layak::getTotalGcr($icno, 0); ?>" disabled="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penyelarasan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'layak_selaras', [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent', 'disabled' => false]
                    ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Masukkan Jumlah Penyelarasan"])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Supporting Document <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Dokumen Sokongan"></i>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'adjfile', ['enableAjaxValidation' => false])->fileInput()->label(false); ?>
                </div>

            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div> <!-- end of xpanel-->
</div> <!-- end of md-->