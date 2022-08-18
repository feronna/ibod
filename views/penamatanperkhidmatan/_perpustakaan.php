<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kontrak\Kontrak;
use yii\helpers\ArrayHelper;
use kartik\widgets\SwitchInput;
use wbraganca\dynamicform\DynamicFormWidget;
error_reporting(0);
$bil=1;
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
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

<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => 'form-horizontal']]); ?>

        <div class="row">  
    <div class="x_panel">
        <h2><strong>Berdasarkan rekod jabatan, sila sahkan perkara berikut: </strong></h2>
        <br>
        <div class="x_content">
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modelCustomer, 'status')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'ADA MEMINJAM BUKU', '0' => 'TIADA MEMINJAM BUKU'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "1"){
                        $("#form").show();
                        }
                        else{
                        $("#form").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
        </div>
        <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 20, // the maximum times, an element can be cloned (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsAddress[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'item',
                            'baki'
                        ],
                    ]); ?>
                            <div id="form" style="display:<?php if($modelCustomer->status==0){echo none;}?>" class="container-items">
                                <div align="center"><b>SENARAIKAN BUKU TERSEBUT<span style="color: red" class="required">*</span> :
                                    </b></div><br>
                            <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                                <div class="item"><!-- widgetBody -->
                                        <?php
                                            // necessary for update action.
                                            if (! $modelAddress->isNewRecord) {
                                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                            }
                                        ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item"><span class="panel-title-address"><?= ($index + 1) ?></span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]item")->textInput(['maxlength' => true, 'placeholder' => 'Nama Buku'])->label(false) ?>
                                            </div>
                                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="baki"></label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]baki")->textInput(['maxlength' => true, 'placeholder' => "Baki (RM)", 'type' => 'number', 'step'=>".01", 'min' => '0.00'])->label(false) ?>
                                            </div>
                                        </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>

         
            <div class="form-group" align="center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>


