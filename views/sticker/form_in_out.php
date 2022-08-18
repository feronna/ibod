<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DateTimePicker;
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Pelawat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-6"> 
                    <?=
                    $form->field($model, 'type')->label(false)->widget(Select2::classname(), [
                        'data' => [1 => 'Pelawat', 2 => 'Pelancong', 3 => 'Kontraktor luar/Tidak berdaftar'],
                        'options' => ['placeholder' => 'Pilih Jenis', 'class' => 'form-control col-md-7 col-xs-12'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Kereta:  
                </label>
                <div class="col-md-3 col-sm-3 col-xs-6">  
                    <?= $form->field($model, 'reg_number')->textInput(['maxlength' => true])->label(false); ?> 
                </div> 
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Kenderaan:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-6"> 
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Warna Kenderaan: 
                </label>
                <div class="col-md-3 col-sm-3 col-xs-6"> 
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tujuan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-6"> 
                    <?= $form->field($model, 'reason')->textarea(array('rows' => 3))->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Destinasi:  <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-6"> 
                    <?= $form->field($model, 'place')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\esticker\RefDestinasi::find()->all(), 'id', 'nama'),
                        'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Kampus:  <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-6"> 
                    <?=
                    $form->field($model, 'campus_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\Kampus::find()->all(), 'campus_id', 'campus_name'),
                        'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12'],
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Anggaran Tarikh/Masa Keluar: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-6">   
                    <?=
                    $form->field($model, 'check_out')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => '....'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ])->label(false);
                    ?> 
                </div>
            </div>
        </div> 

        <div class="hide">
            <?php if ($title == 'Daftar Masuk') { ?> 
                <?= $form->field($model, 'created_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
                <?= $form->field($model, 'check_in')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>
            <?php } else { ?>
                <?= $form->field($model, 'updated_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
                <?= $form->field($model, 'updated_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 

            <?php } ?>
        </div>


        <div class="form-group text-center">
            <div class="row">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>   
        <?php ActiveForm::end(); ?>

    </div>
</div> 
