<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
/* @var $this yii\web\View */
/* @var $model app\models\hronline\tblpenempatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblpenempatan-form">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    
    <div class="x_panel">
    <div class="x_content">

    <?php //echo $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ?>
        
<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No. KP / Paspot: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php //echo $form->field($model, 'ICNO')->textInput(['maxlength' => true])->label(false) ?>
        </div>
    </div>-->

    <?php //echo $form->field($model, 'date_start')->textInput() ?>      

    <?php //echo $form->field($model, 'date_update')->textInput() ?>
        
<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhKemaskini">Tarikh Kemaskini: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?php//echo $form->field($model, 'date_update')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'date_update' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>-->

    <?php //echo $form->field($model, 'dept_id')->textInput() ?>
        
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

    <?php //echo $form->field($model, 'campus_id')->textInput() ?>
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kampus">Kampus: <span class="required" style="color:red;">*</span>
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

    <?php //echo $form->field($model, 'reason_id')->textInput() ?>
        
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

    <?php //echo $form->field($model, 'letter_order_refno')->textInput(['maxlength' => true]) ?>
        
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

    <!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Mula: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                <?php //echo
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'date_start',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhMula">Tarikh Mula: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?= $form->field($model, 'date_start')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'date_start' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>

    <?php //echo $form->field($model, 'update_by')->textInput(['maxlength' => true]) ?>

   <div class="form-group text-center">
        <?php //echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        </div>
</div>