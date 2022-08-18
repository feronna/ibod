<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel">
    <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><?= Html::a('Rekod Lantikan', Yii::$app->request->referrer) ?></li>
                <li>Tambah Rekod Lantikan</li>
            </ol>
            <h2><strong>Tambah Rekod Lantikan</strong></h2>
        <div class="clearfix"></div>
    </div>
        
    <div class="x_content">
     
<!--    <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No. KP / Paspot: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php //echo $form->field($model, 'ICNO')->textInput(['maxlength' => true])->label(false) ?>
                </div>
    </div>-->
    
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

    <?php if(in_array($biodata->gredJawatan,array(2,3,4,5,6,398,407),true)){?>
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jawatantadbir">Jawatan Pentadbiran (2): <span class="required" style="color:red;">*</span> 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
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
    <?php }?>

    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
    </div>

<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Sef:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php //echo $form->field($model, 'description_sef')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
    </div>-->

     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">JFPIB: <span class="required" style="color:red;">*</span>
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
    
<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Lantikan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                <?php //echo
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'start_date',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
            </div>
    </div>-->

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
      
<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Kuatkuasa: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                <?php //echo
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'appoinment_date',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
            </div>
    </div>-->
    
    <!-- Tarikh Kuatkuasa sama dengan tarikh mula untuk rekod penempatan -->
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
        
<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Tamat: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                <?php //echo
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'end_date',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
            </div>
    </div>-->

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

    <!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fail">Muatnaik: <span class="required" style="color:red;">*</span>
            </label>
             <div class="col-md-6 col-sm-6 col-xs-12">
                <?php//echo $form->field($model, 'files')->fileInput()->label(false);?>
            </div>
    </div> -->

    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fail">Muatnaik: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'files')->fileInput()->label(false);?>
            </div>
    </div> 

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flag">Status: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo
                $form->field($model, 'flag')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Flag::find()->all(), 'flag_id', 'flagstatus'),
                    'options' => ['placeholder' => 'Pilih Status Lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>  
     
<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="renew">Status Pembaharuan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php //echo
                $form->field($model, 'renew')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Renew::find()->all(), 'renew_id', 'renewstatus'),
                    'options' => ['placeholder' => 'Pilih Status Pembaharuan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div> -->       

<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus">Status Tugas: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo//
                $form->field($model, 'status_tugas')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Tugasstatus::find()->all(), 'tugasstatus_id', 'tugasstatus_desc'),
                    'options' => ['placeholder' => 'Pilih Status Tugas', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>   -->


    <div class="x_title">
        <h2 style="color: red;">Mohon untuk mengemaskini maklumat penempatan dibawah</h2>
        <div class="clearfix"></div>
    </div>      
    <br>
    <!-- Dari borang tblpenempatan -->
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sebabPerpindahan">Sebab Perpindahan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                $form->field($model, 'reason_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\RefReasonPenempatan::find()->all(), 'reason_id', 'name'),
                    'options' => ['placeholder' => 'Sebab Perpindahan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
    </div>  
    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noRuj">No. Ruj. Surat Arahan Penempatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'letter_order_refno')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
    </div>

    <?php //echo $form->field($model, 'date_letter_order')->textInput() ?>
        
<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"  for="tarikhSurat">Tarikh Surat Arahan Penempatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                <?php //echo
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'date_letter_order',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
            </div>
    </div>    -->

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhMula">Tarikh Surat Arahan Penempatan: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?= $form->field($model, 'date_letter_order')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'date_letter_order' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>

    <?php //echo $form->field($model, 'letter_refno')->textInput(['maxlength' => true]) ?>
        
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noRujSurat">No. Ruj. Surat:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'letter_refno')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
    </div>

    <?php //echo $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
        
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">Catatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
    </div>

    <br>
        
    <div class="form-group text-center">
        <?php //echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
    </div>
    </div>
</div>