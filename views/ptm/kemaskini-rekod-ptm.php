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
                 <li><?= Html::a('Lihat Rekod',['view2', 'id'=>$model->ICNO])  ?></li>
                 <li><?= Html::a('Senarai Rekod Kursus', Yii::$app->request->referrer) ?></li>
                <li>Kemaskini Rekod</li>
            </ol>
            <h2><strong>Kemaskini Rekod</strong></h2>
        <div class="clearfix"></div>
    </div>-->
        
    <div class="x_content">

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bil. Mesyuarat:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'bilMesyuarat')->textInput(['maxlength' => true, 'placeholder' => 'Mesyuarat kali ke-']) ->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat:<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhMesyuarat')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kelulusan:<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhPtm')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Kursus:<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhPtm1')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Kursus:<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhPtm2')->widget(DatePicker::className(),
            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
            'options' => [ 'placeholder' => 'Pilih Tarikh']])->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Kursus:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tempatPtm')->textArea(['maxlength' => true, 'placeholder' => 'Tempat kursus yang dihadiri']) ->label(false);?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kursus Siri:<span class="required" style="color:red;">*</span></label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'siri')->textInput(['maxlength' => true, 'placeholder' => 'Kursus Siri']) ->label(false);?>
            </div>
        </div>

        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status:<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                        'data' => ['LULUS' => 'Hadir dengan Jaya Program Transformasi Minda', 'GAGAL' => 'Gagal - 59 markah dan ke bawah', 'TIDAK MELENGKAPKAN PTM' => 'Tidak Melengkapkan PTM - Tidak Hadir Aktiviti', 'TUNGGU KELULUSAN' => 'Tunggu Kelulusan', 'PENGECUALIAN PTM' => 'Pengecualian PTM'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>     
                </div>  
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengecualian PTM: </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'pengecualianPtm')->label(false)->widget(Select2::classname(), [
                        //'data' => ['LULUS' => 'Hadir dengan Jaya Program Transformasi Minda', 'GAGAL' => 'Gagal - 59 markah dan ke bawah', 'TIDAK MELENGKAPKAN PTM' => 'Tidak Melengkapkan PTM - Tidak Hadir Aktiviti', 'TUNGGU KELULUSAN' => 'Tunggu Kelulusan', 'PENGECUALIAN PTM' => 'Pengecualian PTM'],
                        'data' => ['HADIR DENGAN JAYA PTM' => 'Hadir dengan Jaya PTM', 'HADIR DENGAN JAYA KURSUS INDUKSI - MODAL UMUM' => 'Hadir dengan Jaya Kursus Induksi - Modal Umum', 'LULUS PEPERIKSAAN AM KERAJAAN DI SKIM PERKHIDMATAN TERDAHULU' => 'Lulus Peperiksaan Am Kerajaan di Skim Perkhidmatan terdahulu'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>     
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
