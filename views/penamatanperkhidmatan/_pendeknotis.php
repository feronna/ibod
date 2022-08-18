<?php
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\penamatanperkhidmatan\RefSebabpendeknotis;
use app\models\penamatanperkhidmatan\TblPermohonan;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\penamatanperkhidmatan\TblKontrak;
$form = ActiveForm::begin(['options' => ['id' => 'dynamic-form', 'class' => 'form-horizontal form-label-left']]); 
           ?>
<div style="background-color: #F7F7F7" class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Pemendekan Tempoh Notis</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                Sebab Pemendekan Tempoh Notis<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'sebabpendeknotis_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefSebabpendeknotis::find()->all(), 'id', 'sebab'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript: if($(this).val() === "5"){
                                $("#lainpendek").show();
                            }else{$("#lainpendek").hide();}'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
        <div style="display:none" id="lainpendek" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Lain-lain<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="tblpermohonan-sebab" class="form-control" name="TblPermohonan[sebab]" rows="2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'file')->fileInput()->label(false); ?>
            </div>
        </div>
        </div></div>
<?php ActiveForm::end();?>