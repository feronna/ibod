<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');
use yii\helpers\Html;
use yii\helpers\Url;    
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
error_reporting(0); 
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
$title = $this->title = 'Ringkasan Penyelidikan';

?>




<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

     
    <div class='row'>   

        <div class="col-xs-12 col-md-12 col-lg-12">

 <div class="panel panel-success">

                <div class="panel-heading">
        <h6><strong><i class="fa fa-user-circle"></i> MAKLUMAT PERIBADI</strong></h6> 
                </div>
   

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                
                       <tr> 
                        <th style="width:10%" align="right">NAMA</th>
                        <td style="width:20%"><?=
                        strtoupper($biodata->CONm) ?></td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">UMUR</th>
                        <td style="width:20%"> <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></td>
                       
                    </tr>
                      
                    <tr>   
                                <th>TEMPOH PERKHIDMATAN KESELURUHAN</th>  
                                <td colspan="2"><small><?= strtoupper($biodata->servPeriodPermanent);   ?></small></td> 
                            </tr>  
                    
                     
                    
                    
                     
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div>
                    
    


         
        
        
        


    </div>
    </div>
    
</div>
    </div>
    </div>
        <?php ActiveForm::end(); ?>
  
  



