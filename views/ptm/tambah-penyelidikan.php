<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
<!--    <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['index']) ?></li>

                <li>Tambah Rekod</li>
            </ol>
            <h2><strong>Tambah Rekod</strong></h2>
        <div class="clearfix"></div>
    </div>-->
        
    <div class="x_content">
        
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan:<span class="required" style="color:red">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                        if ($model->ICNO) {
                            echo $form->field($model->kakitangan, 'CONm')->textInput(['disabled' => 'disabled'])->label(false);
                        }
                        else {  
                            echo $form->field($model, 'ICNO')->label(false)->widget(Select2::classname(), 
                        [
                            'data' => $allbiodata,
                            'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12', 'required' => TRUE],
                            'pluginOptions' => ['allowClear' => true],
                        ]);
                        }
                    ?>
                </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pembentangan:<span class="required" style="color:red;">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhPembentangan')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh', 'required' => TRUE]])->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk Pembentangan:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tajukPembentangan')->textArea(['maxlength' => true, 'placeholder' => 'Tajuk pembentangan', 'required' => TRUE]) ->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Pembentangan:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tempatPembentangan')->textArea(['maxlength' => true, 'placeholder' => 'Tempat pembentangan', 'required' => TRUE]) ->label(false);?>
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status:<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                        'data' => ['LULUS' => 'LULUS', 'GAGAL' => 'GAGAL'],
                        'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12', 'required' => TRUE],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>     
                </div>  
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kelulusan TNC(A):<span class="required" style="color:red;">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhKelulusan')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh', 'required' => TRUE]])->label(false);?>
            </div>
        </div>
        
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus Metodologi:<span class="required" style="color:red;">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <= $form->field($model, 'tarikhLulusPembentangan')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>-->

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['rekod-penyelidikan', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
</div>
