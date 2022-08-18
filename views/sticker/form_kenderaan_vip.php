<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\esticker\TblStickerStaf */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?=
                    $form->field($model, 'id_lpu')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\TblAhliLembagaPengarah::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Nama', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Pemilik Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'veh_owner')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Hubungan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?=
                    $form->field($model, 'rel_owner_user')->label(false)->widget(Select2::classname(), [
                        'data' => ['DIRI SENDIRI' => 'DIRI SENDIRI', 'SUAMI' => 'SUAMI', 'ISTERI' => 'ISTERI'
                            , 'ANAK' => 'ANAK', 'BAPA' => 'BAPA', 'IBU' => 'IBU'
                            , 'BAPA MERTUA' => 'BAPA MERTUA', 'IBU MERTUA' => 'IBU MERTUA', 'KAKAK' => 'KAKAK'
                            , 'ABANG' => 'ABANG', 'ADIK' => 'ADIK', 'ATUK' => 'ATUK', 'NENEK' => 'NENEK', 'SEPUPU' => 'SEPUPU', 'LAIN-LAIN' => 'LAIN-LAIN'
                        ],
                        'options' => ['placeholder' => 'Pilih Hubungan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Kereta: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'reg_number')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Warna Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?=
                    $form->field($model, 'veh_color')->label(false)->widget(Select2::classname(), [
                        'data' => [ 'HITAM' => 'HITAM', 'PUTIH' => 'PUTIH', 'PERAK' => 'PERAK'
                            , 'EMAS' => 'EMAS', 'COKLAT' => 'COKLAT', 'KELABU' => 'KELABU'
                            , 'BIRU' => 'BIRU', 'MAROON' => 'MAROON', 'MERAH' => 'MERAH'
                            , 'MERAH JAMBU' => 'MERAH JAMBU', 'JINGGA' => 'JINGGA', 'KUNING' => 'KUNING',
                            'HIJAU' => 'HIJAU', 'UNGU' => 'UNGU', 'PEACH' => 'PEACH'
                        ],
                        'options' => [ 'placeholder' => 'Pilih Warna', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?=
                    $form->field($model, 'veh_type')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\RefJenisKenderaan::find()->where(['IN','Keterangan',['KERETA','MOTOSIKAL']])->all(), 'KODJENIS', 'Keterangan'),
                        'options' => [ 'placeholder' => 'Pilih Jenis Kenderaan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenama Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?=
                    $form->field($model, 'veh_brand')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\RefJenamaKenderaan::find()->all(), 'KODMODEL', 'KETERANGAN'),
                        'options' => [ 'placeholder' => 'Pilih Jenama Kenderaan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Model Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'veh_model')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Lesen:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'lesen_no')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tarikh Tamat Lesen:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'lesen_exp',
                        'template' => '{input}{addon}',
                        'options' => [ 'class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Roadtax:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'roadtax_no')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tarikh Tamat Roadtax:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'roadtax_exp',
                        'template' => '{input}{addon}',
                        'options' => [ 'class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>   
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Catatan Modifikasi Kenderaan:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'catatan_modifikasi')->textarea(['rows' => 3, 'maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>  
        <div class="hide">
            <?= $form->field($model, 'apply_type')->hiddenInput([ 'value' => 'BARU'])->label(false); ?> 
            <?= $form->field($model, 'daftar_date')->hiddenInput([ 'value' => date('Y-m-d')])->label(false); ?>   
            <?= $form->field($model, 'updater')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
            <?= $form->field($model, 'status_kenderaan')->hiddenInput(['value' => 'AKTIF'])->label(false); ?>  
        </div>
        <div class="form-group text-center">
            <div class="row">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, [ 'class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>


    </div>
</div> 

<?php ActiveForm::end(); ?>