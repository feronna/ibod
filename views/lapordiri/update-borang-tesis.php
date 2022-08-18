<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>
<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("lanjutanedt").value);
                var pickdt = new Date(document.getElementById("lanjutansdt").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("lanjutanedt")){
            document.getElementById("tempoh").value=GetDays();
        }  
        }
        
</script>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>MUAT NAIK SEMULA DOKUMEN TUNTUTAN ELAUN TESIS</center></strong> </h5>
 <div class="x_panel">
<div class="x_title">
    <h5 ><strong><i class="fa fa-th-list"></i> MAKLUMAT PERMOHONAN</strong><br><br>
       </h5>
   
            
</div>
               
        <div class="x_content">
     
           
        <div class="table-responsive">
            
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                 <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS - KPT</center></th>

                     <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">
                       SURAT SENAT/SCROLL PHD/PENGESAHAN JAM KREDIT MELEBIHI 6 JAM BAGI SARJANA SAHAJA
                            :</th>
                     
                                                <td class="text-justify"> 
                                                                <?= $form->field($model, 'file')->fileInput()->label(false);?>
                                                    

                    
                    </tr>
                    
                     <tr class="headings">
                        <th class="col-md-6 col-sm-6 col-xs-12">
                    MAKLUMAT BANK SERTA PENYATA BANK:
                            :</th>
                     
                   <td class="text-justify">             <?= $form->field($model, 'file2')->fileInput()->label(false);?>
                       

                   </td>
                        
                    </tr>
                                            <th class="col-md-6 col-sm-6 col-xs-12">
HARD COVER TESIS</th>
                            <td  class="text-left" rowspan="2" style="color: green;"> <small><b>
                                        DIHANTAR KE BSM (PN. DAYANG NOORANIZAH) BERSAMA<BR> BORANG TUNTUTAN ELAUN TESIS
                                        (KPT) YANG DITANDATANGANI</b></small></td>
                                        <tr>     
                                
                                                   <th class="col-md-6 col-sm-6 col-xs-12">
SALINAN SOFT COPY TESIS DALAM BENTUK CD</th>

                       <p style="color:red;"> ** Tuntutan hendaklah dibuat dalam tempoh 6 tahun dari tarikh mula pengajian bagi peringkat pengajian PhD
                           manakala 3 tahun dari tarikh mula pengajian bagi peringkat pengajian Sarjana.</p>
                     
                    
                    

                     
                </table>
            </div>  </div>  </div>

        
  
       
      
         
        
       



  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




