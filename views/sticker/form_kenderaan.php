<?php
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker; 
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;"><?= strtoupper($title); ?></p> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Pemilik Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8"> 
                    <?= $form->field($model, 'veh_owner')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Pengguna Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?= $form->field($model, 'veh_user')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Hubungan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">   
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
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">No. Kereta: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?= $form->field($model, 'reg_number')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Warna Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">   
                    <?=
                    $form->field($model, 'veh_color')->label(false)->widget(Select2::classname(), [
                        'data' => ['HITAM' => 'HITAM', 'PUTIH' => 'PUTIH', 'PERAK' => 'PERAK'
                            , 'EMAS' => 'EMAS', 'COKLAT' => 'COKLAT', 'KELABU' => 'KELABU'
                            , 'BIRU' => 'BIRU', 'MAROON' => 'MAROON', 'MERAH' => 'MERAH'
                            , 'MERAH JAMBU' => 'MERAH JAMBU', 'JINGGA' => 'JINGGA', 'KUNING' => 'KUNING', 
                              'HIJAU' => 'HIJAU','UNGU' => 'UNGU','PEACH' => 'PEACH'
                        ],
                        'options' => ['placeholder' => 'Pilih Warna', 'class' => 'form-control col-md-7 col-xs-12'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Jenis Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?=
                    $form->field($model, 'veh_type')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\RefJenisKenderaan::find()->where(['IN','Keterangan',['KERETA','MOTOSIKAL']])->all(), 'KODJENIS', 'Keterangan'),
                        'options' => ['placeholder' => 'Pilih Jenis Kenderaan', 'class' => 'form-control col-md-7 col-xs-12'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Jenama Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?=
                    $form->field($model, 'veh_brand')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\RefJenamaKenderaan::find()->all(), 'KODMODEL', 'KETERANGAN'),
                        'options' => ['placeholder' => 'Pilih Jenama Kenderaan', 'class' => 'form-control col-md-7 col-xs-12'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Model Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?= $form->field($model, 'veh_model')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Lesen: 
            </label>
            <div class="col-md-6 col-sm-6 col-xs-8">
                <?=
                $form->field($model, 'lesen_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\hronline\Tbllesen::find()->where(['ICNO' => Yii::$app->user->getId()])->all(), 'licId', 'LicNo'),
                    'options' => ['placeholder' => 'Pilih Lesen', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?= Html::a('<i class="fa fa-edit"></i> Lesen', ['lesen'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">No. Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?= $form->field($model, 'lesen_no')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">No. Roadtax: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?= $form->field($model, 'roadtax_no')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Tarikh Tamat Roadtax: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">   
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'roadtax_exp',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => 'required'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Catatan Modifikasi Kenderaan:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?= $form->field($model, 'catatan_modifikasi')->textarea(['rows'=>3,'maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Muatnaik Kad Kereta:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?php
                    if (empty($model->filename_grant)) {
                        echo $form->field($model, 'grant')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_grant), Yii::$app->FileManager->DisplayFile($model->filename_grant), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'grant'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Gambar Kenderaan (Hadapan):  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?php
                    if (empty($model->filename_veh_front)) {
                        echo $form->field($model, 'veh_front')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_veh_front), Yii::$app->FileManager->DisplayFile($model->filename_veh_front), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'veh_front'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Gambar Kenderaan (Tepi):  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?php
                    if (empty($model->filename_veh_side)) {
                        echo $form->field($model, 'veh_side')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_veh_side), Yii::$app->FileManager->DisplayFile($model->filename_veh_side), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'veh_side'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-4 text-right">Gambar Kenderaan (Belakang):  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-8">  
                    <?php
                    if (empty($model->filename_veh_rear)) {
                        echo $form->field($model, 'veh_rear')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_veh_rear), Yii::$app->FileManager->DisplayFile($model->filename_veh_rear), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'veh_rear'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <br/>
        <div class="form-group text-center">
            <div class="row">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Sila Tunggu..']]) ?>
            </div>
        </div>
        <div class="hide"> 
        <?= $form->field($model, 'v_co_icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
        <?= $form->field($model, 'apply_type')->hiddenInput(['value' => 'BARU'])->label(false); ?> 
        <?= $form->field($model, 'daftar_date')->hiddenInput(['value' => date('Y-m-d')])->label(false); ?> 
        <?= $form->field($model, 'flag_mohon')->hiddenInput(['value' => 0])->label(false); ?> 
        <?= $form->field($model, 'flag_finish')->hiddenInput(['value' => 1])->label(false); ?> 
        <?= $form->field($model, 'updater')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
        <?= $form->field($model, 'status_kenderaan')->hiddenInput(['value' => 'AKTIF'])->label(false); ?>  
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div> 
