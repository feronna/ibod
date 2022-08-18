<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
error_reporting(0);
$bil=1;
?>

<?= $this->render('_topmenu') ?><?= $this->render('_maklumatpemohon',['model'=> $model]) ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

        <div class="row">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Pengesahan JFPIU </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <i>[Tarikh terakhir dikemaskini : <?= $model->tarikh_bsm?>]</i>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelCustomer, 'status_bsm')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'BELUM menamatkan tempoh ikatan
seperti yang dinyatakan dalam perjanjian tajaan melanjutkan pengajian', '0' => ' TELAH menamatkan tempoh ikatan
seperti yang dinyatakan dalam perjanjian tajaan melanjutkan pengajian'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "1"){
                       $("#form").show();
                        $(".form-control").prop("required",true);
                        }
                        else{
                        $("#form").hide();
                        $(".form-control").prop("required",false);
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
            
            <div id="form" style="display:<?php if($modelCustomer->status_bsm==0){echo none;}?>" class="form-group">
            <label class="control-label col-md-6 col-sm-6 col-xs-12">TEMPOH PERKHIDMATAN YANG BELUM DIPENUHI [TAHUN]<span style="color: red" class="required">*</span> :
            </label>
                <div class="col-md-2 col-sm-2 col-xs-6">
                <?= $form->field($modelsAddress, 'baki')->textInput(['type' => 'float', 'required' => true])->label(false) ?>
            </div>
        </div>
        </div>

         
            <div class="form-group" align="center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>


