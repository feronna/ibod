<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url; 


$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);


error_reporting(0);
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<p align="right">  <?= Html::a('Back', ['lkk/senarailkk', 'id'=>$model->icno], ['class' => 'btn btn-primary btn-sm']) ?></p>


<div class="x_panel">
    
        <div class="x_content">  
            <span class="required" style="color:black;">
               
                <center> <h5><strong><?= strtoupper('
    PROGRESS REPORT
 '); ?>
                        </strong></h5> </center>
            </span> 
        </div>
    </div>


       <div class="x_panel">
        <div class="x_title">
           <strong><i class="fa fa-user-circle"></i> STUDENT'S DETAIL</strong>
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">LAST DATE SUBMISSION:</th>
                        <td><?= strtoupper($model->dt);?></td> 
                       
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMESTER/SESSION:</th>
                        <td><?= strtoupper($model->semester);?>/<?= strtoupper($model->session);?></td> 
                       
                    </tr>
                   
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">FULL NAME:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">STUDENT ID:</th>
                        <td><?= $model->pengajian->studentno; ?></td> 
                    </tr>
                 
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ICNO:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">LEVEL OF STUDY:</th>
                        <td><?= strtoupper($model->pengajian->tahapPendidikan); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERIOD AND PLACE OF STUDY APPROVED:</th>
                        <td>(DARI) <?= strtoupper($model->pengajian->tarikhmula); ?> (HINGGA) <?= strtoupper($model->pengajian->tarikhtamat); ?>  |  
                        <?php 
                        
                        if($model->pengajian->l->renewTempat)
                        {?>
                            <?= ucwords(strtoupper($model->pengajian->l->renewTempat)) ?>
                      <?php  }else{?>
                          
                                                      <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>

               <?php       }
?>
                        
                          </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">THESIS TITLE:</th>
                        <td><?= $model->pengajian->tajuk_tesis; ?></td> 
                    </tr>
                     
                    
                    
                     
            
               
                    

                     
                </table>
            </div> 

        </div>
        </div>
        
        <div class="x_panel">
        <div class="x_title">
            
            <i class="fa fa-paperclip"></i><strong> SUPPORTING DOCUMENT</strong>
                
                    <div class="clearfix"></div>
                    
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    
                    
                    
                    
                   
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">DOCUMENT/EVIDENCE:</th>
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i class="fa fa-file-pdf-o"></i></a><br>
                       

                        
                    </tr>
                    

                     
                </table>
            </div> 

            
        </div>
        </div>
        

     
     
  
            
        
       
      
            <?php ActiveForm::end(); ?>
 


 