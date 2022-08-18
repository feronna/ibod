<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\kehadiran\TblRekod;
use yii\helpers\Url;

error_reporting(0);
$statusLabel = [
        1 => 'Selesai Disemak',
        0 => 'Ditolak',
        null => 'Belum Disemak'

];
$pencen= [
        1 => 'Berpencen',
        0 => 'Tidak Berpencen',

];
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>PENGESAHAN BRP</strong></h2>
           
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= strtoupper($model->kakitangan->CONm)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
              <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= strtoupper($model->kakitangan->ICNO)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis BRP
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= strtoupper($model->brpCd)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>

            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Butir-butir perubahan atau lain-lain hal mengenai pegawai
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                               
                               <textarea class="form-control" rows="10" disabled><?= $model->remark?></textarea>
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mulai daripada / Kuatkuasa
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->tarikhMulai?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Hingga
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->tarikhHingga?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Rujukan Surat
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->rujukan_surat?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Surat
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->tarikhSurat?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pencen
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $pencen[$model->isPencen]?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan Pegawai
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                            <input type="text"  class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $statusLabel[$model->status]?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
             </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengesahan
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'sah')->label(false)
                            ->dropDownList(
                                    ['1' => 'DITERIMA', '0' => 'DITOLAK'], // Flat array ('id'=>'label')
                                    ['prompt' => '--Sila Pilih Status Perakuan--']    // options
                    );
                    ?>
                </div>
            </div>
          
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>
