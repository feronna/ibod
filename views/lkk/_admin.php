<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;


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
<p align="right">  <?= Html::a('Kembali', ['cbadmin/view-lkk', 'id'=>$model->icno], ['class' => 'btn btn-primary btn-sm']) ?></p>


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
                        <th class="col-md-3 col-sm-3 col-xs-12">SEMESTER:</th>
                        <td><?= strtoupper($model->semester);?></td> 
                       
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">SESI:</th>
                        <td><?= $form->field($model, 'session')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?></td>
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
                        <td><?= strtoupper($b->tahapPendidikan); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TEMPOH DAN TEMPAT BELAJAR YANG DILULUSKAN:</th>
                        <td>(DARI) <?= strtoupper($b->tarikhmula); ?> (HINGGA) <?= strtoupper($b->tarikhtamat); ?>  |  <?= ucwords(strtoupper($b->InstNm)) ?>  </td> 
                    </tr>
                    
                     
                    
                    
                     
            
               
                    

                     
                </table>
            </div> 

        </div>
        </div>
        
        <div class="x_panel">
        <div class="x_title">
            <h2><strong>DOKUMEN SOKONGAN</strong></h2> 
                    <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                     
                    
                    
                    
                   <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">DOKUMEN/BUKTI:</th>
                        <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                  
                    

                     
                </table>
            </div> 

            
        </div>
        </div>
        

     
     
  
            
        
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
       
      
            <?php ActiveForm::end(); ?>
 


 