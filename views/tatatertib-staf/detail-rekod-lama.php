<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
 

$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';
error_reporting(0);
?>
 
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5><strong><i class="fa fa-info"></i> Detail Rekod Lama</strong></h5> 
              
           
            
            <div class="clearfix"></div>

          
            </div>
            <div class="x_content">
 <form id="w0" class="form-horizontal form-label-left" action="" method="post">
   
                 <div class="clearfix"></div>
               
 
                 
                 
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->kakitangan->CONm?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
        
      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kesalahan:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->jenisKesalahan->kesalahan_nm?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
    
  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kes:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->kes?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
        
             
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Kesalahan:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->tarikh_mula_kesalahan ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
        
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Akhir Kesalahan:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->tarikh_akhir_kesalahan?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                 
                 
              <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Rayuan:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->rayuan?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>      
                 
                 
       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Rayuan:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->catatan_rayuan?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                 
                        
          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Hukuman:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->jenisHukuman->hukuman_nm?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                 
                 
                                  
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Hukuman:
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->catatan_hukuman?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
         
 </form>

            </div>
        </div>
    </div>
  
</div>