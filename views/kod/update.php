<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\hronline\Department;
use yii\helpers\Url;
use app\models\hronline\Tblprcobiodata;
use kartik\widgets\SwitchInput;


?>
<div class="col-md-12"> 
    <div class="x_panel">


<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fullname<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'fullname')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Shortname<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'shortname')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'chief')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Tblprcobiodata::find()->All(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Ketua Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Pendaftar<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'pp')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Tblprcobiodata::find()->All(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Ketua Pentadbiran', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'address')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax No<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'fax_no')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Telefon No<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'tel_no')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pa Email<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
<?= $form->field($model, 'pa_email')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Department<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'dept_cat_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\DeptCat::find()->all(), 'id', 'category'),
                    'options' => ['placeholder' => 'Pilih Kategori Department', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Daripada Department<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'sub_of')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Department::find()->all(), 'id', 'fullname'),
                    'options' => ['placeholder' => 'Pilih Sub Daripada Department', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'isActive')->label(false)->widget(Select2::classname(), [
                    'data' => ['1' => 'Aktif', '0' => 'Tidak Aktif'],
                    'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['kod/index'], ['class' => 'btn btn-warning']) ?> 

                <button class="btn btn-primary" type="reset">Reset</button>
<?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>
    </div>
</div>