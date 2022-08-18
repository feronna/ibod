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
    <?php $model->tempv3 = 0;
    echo Yii::$app->controller->renderPartial('_staff_details', ['biodata' => $biodata,]); ?>

        <div class="x_title">
            <h2>Penyelarasan Cuti</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>


          
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">GCR Terkumpul<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo Layak::getTotalGcr($model->layak_icno, 0) ?>" disabled="true">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">GCR<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'layak_gcr')->textInput(['maxlength' => true, 'rows' => 4,'readonly' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penyelarasan GCR<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tempv3')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penyelarasan CBTH<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'layak_bawa_depan')->textInput(['maxlength' => true, 'rows' => 4,'readonly'=>true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penyelarasan Lupus<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'layak_hapus')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <?= $form->field($model, 'layak_icno')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>
            <?= $form->field($model, 'layak_gcr')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>
           
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index'],'data' => ['confirm' => 'Are You Sure to adjust this GCR??']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div> <!-- end of xpanel-->
</div> <!-- end of md-->