<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<h5> <strong><center>MUAT NAIK PENGESAHAN DOKUMEN PERMOHONAN KPT<br>
            <small>Sila Pastikan Dokumen yang dimuatnaik adalah <b style="color:red">
                    LENGKAP DAN DISAHKAN BENAR</b> bagi mengelakkan sebarang kesulitan/
                    kelewatan proses permohonan.</small></center></strong></h5>
<center><small>Pastikan klik <i>Browse</i> untuk memuatnaik dokumen.<br> Sila tunggu dan pastikan <i>Pop up - Berjaya Disimpan</i> muncul untuk
                            memastikan fail/dokumen yang dimuatnaik berjaya disimpan.<br> Jika "Tiada Bukti", padam dan muatnaik semula.</small></center>
<center><small style="color:red">Borang KPT yang telah ditandatangan
        dan disahkan hendaklah dihantar kepada Puan Dayang di Bahagian Sumber Manusia.</small></center>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
   


        

        <div class="form-group"  align="center">
            
            <label class="control-label col-md-3 col-sm-3 col-xs-12">MUAT NAIK <span class="required">*</span><br>
                <small style="color:red">MAX SIZE: UP TO 5MB SAHAJA</small>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php if($model->namafile)
                        {
                           ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->namafile), true); ?>" target="_blank" ><u>Download Document</u></a>
                       <?php }
                       else{?>
                           <?= $form->field($model, 'namafile')->fileInput()->label(false);?> </td>

                     <?php  }
?>
                  
                  
                </div>
        </div></div>
        
  
       
      
         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
        
        
         
        
         
        
         

        
        

    </div>
    

    </div>



  
        
        
        
        
        
      
        
        
<?php ActiveForm::end(); ?>




