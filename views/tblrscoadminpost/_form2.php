<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
use app\models\hronline\ProgramPengajaran;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblrscoadminpost-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    
    <div class="x_panel">
        
    <div class="x_content">

    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gelaran">Jawatan Pentadbiran: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'adminpos_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Adminposition::find()->where(['position_type' => $job_group])->all(), 'id', 'position_name'),
                    'options' => ['placeholder' => 'Pilih Jawatan Pentadbiran', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>

<!--    <php if(in_array($biodata->gredJawatan,array(2,3,4,5,6,398,407),true)){?>
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jawatantadbir">Jawatan Pentadbiran (2): <span class="required" style="color:red;">*</span> 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <=
                $form->field($model, 'jawatantadbir_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\JawatanPentadbiran::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Pilih Jawatan Pentadbiran', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>
    <php }?>-->
        
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="program">Program Pengajaran: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo
                $form->field($model, 'program_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\ProgramPengajaran::find()->all(), 'id', 'NamaProgram'),
                    'options' => ['placeholder' => 'Pilih Program Pengajaran', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>

    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">JAFPIB: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'dept_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Department::find()->all(), 'id', 'fullname'),
                    'options' => ['placeholder' => 'Pilih Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>    

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus">Kampus: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'campus_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name'),
                    'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>   
     
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusjawatan">Status Jawatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?=
                $form->field($model, 'jobStatus')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Jobstatus::find()->all(), 'jobstatus_id', 'jobstatus_desc'),
                    'options' => ['placeholder' => 'Pilih Status Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>   
     
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusbayaran">Status Bayaran: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?=
                $form->field($model, 'paymentStatus')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Paymentstatus::find()->all(), 'paymentstatus_id', 'paymentstatus_desc'),
                    'options' => ['placeholder' => 'Pilih Status Bayaran', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>     

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="appointmentdate">Tarikh Lantikan: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?= $form->field($model, 'appoinment_date')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'appoinment_date' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startdate">Tarikh Kuatkuasa: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?= $form->field($model, 'start_date')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'start_date' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enddate">Tarikh Tamat: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?= $form->field($model, 'end_date')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'end_date' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>

    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fail">Muatnaik: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'file')->fileInput()->label(false);?>
            </div>
    </div> 

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flag">Status: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo
                $form->field($model, 'flag')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Flag::find()->all(), 'flag_id', 'flagstatuss'),
                    'options' => ['placeholder' => 'Pilih Status Lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>     
   
    <br>
        
    <div class="form-group text-center">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    </div>
        
    </div>
    
</div>