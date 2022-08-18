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
    <div class="x_content">

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kursus:<span class="required" style="color:red;">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhBitk')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Kursus:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tempatBitk')->textArea(['maxlength' => true, 'placeholder' => 'Tempat kursus yang dihadiri']) ->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Peperiksaan:<span class="required" style="color:red;">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhExam')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Peperiksaan:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tempatExam')->textArea(['maxlength' => true, 'placeholder' => 'Tempat kursus yang dihadiri']) ->label(false);?>
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status:<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                        'data' => ['LULUS' => 'LULUS', 'GAGAL' => 'GAGAL'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>     
                </div>  
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Surat Kelulusan (JPA):<span class="required" style="color:red;">*</span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhKelulusan')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
</div>
