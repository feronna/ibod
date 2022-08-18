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
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<p align="right">  <?= Html::a('Kembali', ['pp-view-lkk', 'id'=>$model->icno], ['class' => 'btn btn-primary btn-sm']) ?></p>


<div class="x_panel">
        <div class="x_content">  

            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | 
     SEKTOR PEMBANGUNAN SUMBER MANUSIA<br/><u> PROGRESS REPORT
 '); ?>
                </center>  </strong>
            </span> 
        </div>
    </div>


       <div class="x_panel">
        <div class="x_title">
            <h2><strong>MAKLUMAT KAKITANGAN</strong></h2> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH AKHIR PENGHANTARAN:</th>
                        <td><?= strtoupper($model->dt);?></td> 
                       
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMESTER/SESI:</th>
                        <td><?= strtoupper($model->semester);?>/<?= strtoupper($model->session);?></td> 
                       
                    </tr>
                   
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA PENUH:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMSPER:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                 
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO KAD PENGENALAN:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td><?= strtoupper($model->pengajian->tahapPendidikan); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TEMPOH DAN TEMPAT BELAJAR YANG DILULUSKAN:</th>
                        <td>(DARI) <?= strtoupper($model->pengajian->tarikhmula); ?> (HINGGA) <?= strtoupper($model->pengajian->tarikhtamat); ?>  | 
<?php if($model->pengajian->l->renewTempat)
                        {?>
                            <?= ucwords(strtoupper($model->pengajian->l->renewTempat)) ?>
                      <?php  }else{?>
                          
                                                      <?= ucwords(strtoupper($model->pengajian->InstNm)) ?>

               <?php       }
?>  </td> 
                    </tr>
                    
                    <?php 
                         foreach($model->pengajian->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th class="col-md-3 col-sm-3 col-xs-12">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td>

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?> (<?= strtoupper($l->tempohlanjutan);?>)</td>
                         </tr><?php }?>
                    
                    
                     
                    
                    
                     
            
               
                    

                     
                </table>
            </div> 

        </div>
        </div>
        
        <div class="x_panel">
        <div class="x_title">
            
            <h2><strong>DOKUMEN SOKONGAN</strong>
            </h2>    
                    <div class="clearfix"></div>
                    
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                             
                    
                    
                   
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">DOKUMEN/BUKTI:</th>
                        <td class="text-justify"> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i class="fa fa-file-pdf-o"></i></a><br>
                       

                        
                    </tr>
                    

                     
                </table>
            </div> 

            
        </div>
        </div>
        

     
     
  
            
        
       
      
            <?php ActiveForm::end(); ?>
 


 