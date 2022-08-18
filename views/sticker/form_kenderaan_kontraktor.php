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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Kontraktor: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?php
                    if ($model->id_kontraktor) {
                        echo $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->where(['apsu_suppid' => $model->id_kontraktor])->all(), 'apsu_suppid', 'apsu_lname'),
                            'options' => ['class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]);
                    } else {
                        echo $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->where(['>','DATE(tarikhtamatsah)',date('Y-m-d')])->all(), 'apsu_suppid', 'apsu_lname'),
                            'options' => ['placeholder' => 'Pilih Kontraktor', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No K/P: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'v_co_icno')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Pemilik Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'veh_owner')->textInput(['placeholder'=>'NAMA PEMILIK KERETA / KENDERAAN SYARIKAT','maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Pengguna Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'veh_user')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Hak Milik: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?=
                    $form->field($model, 'rel_owner_user')->label(false)->widget(Select2::classname(), [
                        'data' => ['DIRI SENDIRI' => 'DIRI SENDIRI', 'SYARIKAT' => 'SYARIKAT'
                        ],
                        'options' => ['placeholder' => 'Pilih Pemilikan', 'class' => 'form-control col-md-7 col-xs-12'],
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
                        'data' => ['HITAM' => 'HITAM', 'PUTIH' => 'PUTIH', 'PERAK' => 'PERAK'
                            , 'EMAS' => 'EMAS', 'COKLAT' => 'COKLAT', 'KELABU' => 'KELABU'
                            , 'BIRU' => 'BIRU', 'MAROON' => 'MAROON', 'MERAH' => 'MERAH'
                            , 'MERAH JAMBU' => 'MERAH JAMBU', 'JINGGA' => 'JINGGA', 'KUNING' => 'KUNING',
                            'HIJAU' => 'HIJAU', 'UNGU' => 'UNGU', 'PEACH' => 'PEACH'
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?=
                    $form->field($model, 'veh_type')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\RefJenisKenderaan::find()->all(), 'KODJENIS', 'Keterangan'),
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenama Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Model Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'veh_model')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'lesen_no')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tarikh Tamat Lesen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'lesen_exp',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Roadtax: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($model, 'roadtax_no')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tarikh Tamat Roadtax: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">   
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
        <?php if (Yii::$app->controller->action->id == 'tambah-kenderaan-kontraktor') { ?>
            <div class="hide">
                <?= $form->field($model, 'daftar_date')->hiddenInput(['value' => date('Y-m-d')])->label(false); ?>  
                <?= $form->field($model, 'updater')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
                <?= $form->field($model, 'status_kenderaan')->hiddenInput(['value' => 'AKTIF'])->label(false); ?> 
            </div>
        <?php } else { ?>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Status Kenderaan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?=
                        $form->field($model, 'status_kenderaan')->label(false)->widget(Select2::classname(), [
                            'data' => ['AKTIF' => 'AKTIF', 'TIDAK AKTIF' => 'TIDAK AKTIF'],
                            'options' => ['class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Muatnaik Kad Kereta: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?php
                    if (empty($model->filename_grant)) {
                        echo $form->field($model, 'grant')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_grant), Yii::$app->FileManager->DisplayFile($model->filename_grant), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'grant-kontraktor'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <br/>
        <div class="form-group text-center">
            <div class="row">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>  
        <?php ActiveForm::end(); ?>

    </div>
</div> 
