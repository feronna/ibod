<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<h5> <strong><center>KEPUTUSAN MESYUARAT UNIT PENGAJIAN LANJUTAN (UPL) - CUTI BELAJAR/ CUTI SABATIKAL / LATIHAN INDUSTRI</center></strong> </h5>
<div> 
    <div class="x_panel"> 
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">MESYUARAT KALI KE
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12"  value="<?= $model->mesyuarat->kali_ke;?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MESYUARAT
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12"  value="<?= $model->mesyuarat->tarikhMesyuarat;?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
<!--            <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                     Sila isi ulasan anda seperti contoh berikut untuk kegunaan surat yang akan dijana oleh pengguna. Sila abaikan jika tidak ada ulasan. *Cth: rekod kehadiran adalah tidak memuaskan
        </div>-->
             
 <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Mesyuarat:<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_mesyuarat')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diluluskan' => 'DILULUSKAN', 'Tidak Diluluskan' => 'TIDAK DILULUSKAN','KIV'=>'KIV'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                       
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>

         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan_bsm')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
         <!-- <div class="ln_solid"></div> -->
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>

                </div>
            </div>
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
