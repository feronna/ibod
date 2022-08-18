<?php

use app\models\cuti\SetPegawai;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
// use yii\jui\DatePicker;
use kartik\date\DatePicker;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use kartik\datetime\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Modal;


?>
<?php

error_reporting(0);
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Tambah Cuti Umum </i></strong></h2>

                <div class="clearfix"></div>
            </div>

            <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>



            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsAddress[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'tarikh_cuti',
                    'catatan',
                    'nama_cuti',
                    'sabah_sahaja',
                    'wilayah_sahaja',
                ],
            ]); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        Tambah Cuti
                        <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-items">
                        <!-- widgetContainer -->
                        <?php foreach ($modelsAddress as $i => $modelAddress) : ?>
                            <div class="item panel panel-default">
                                <!-- widgetBody -->
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Action</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Bercuti
                                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti start_date to end_date"></i>
                                        </label>

                                        <div class="col-md-3 col-sm-3 col-xs-12">

                                            <?= $form->field($modelAddress, "[{$i}]tarikh_cuti")->label(false)->widget(DatePicker::classname(), [
                                                'readonly' => true,
                                                'removeButton' => false,
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => 'yyyy-mm-dd'
                                                ],
                                                'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>

                                            <?= $form->field($modelAddress, "[{$i}]sabah_sahaja")->checkbox(array('label' => 'Tandakan jika cuti adalah untuk negeri Sabah Sahaja)')); ?>
                                            <?= $form->field($modelAddress, "[{$i}]wilayah_sahaja")->checkbox(array('label' => 'Tandakan jika cuti adalah untuk Wilayah sahaja)')); ?>

                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Cuti <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($modelAddress, "[{$i}]nama_cuti")->textarea(['rows' => 2])->textarea()->input('nama_cuti', ['placeholder' => "Nama Cuti"])->label(false); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan
                                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($modelAddress, "[{$i}]catatan")->textarea(['rows' => 2])->textarea()->input('catatan', ['placeholder' => "Catatan"])->label(false); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php DynamicFormWidget::end(); ?>





                    <div class="ln_solid"></div>


                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/supervisor/set-leave', 'id' => Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-warning']) ?>
                            <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                            <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

            <?php

       

            $this->registerJs(' 
    $(function () {
        $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
            $( ".dob" ).each(function() {
               $( this ).datepicker({
                  dateFormat : "dd/mm/yy",
                  yearRange : "1925:+20",
                //   maxDate : "-1D",
                  changeMonth: true,
                  changeYear: true
               });
          });          
        });
    });
    $(function () {
        $(".dynamicform_wrapper").on("afterDelete", function(e, item) {
            $( ".dob" ).each(function() {
               $( this ).removeClass("hasDatepicker").datepicker({
                  dateFormat : "dd/mm/yy",
                  yearRange : "1925:+20",
                //   maxDate : "-1D",
                  changeMonth: true,
                  changeYear: true
               });
          });          
        });
    });
    ');
            ?>