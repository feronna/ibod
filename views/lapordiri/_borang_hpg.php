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
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <p align="right"><?= Html::a('Kembali', ['cutibelajar/senarai-borang'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">
    <h2><strong><center>PERMOHONAN HADIAH PERGERAKAN GAJI (HPG)</center></strong></h2>

</div>

<div class="x_panel">

    <div class="x_content">
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <thead>
                    <th scope="col" colspan=12">
                    <center>MAKLUMAT PEMOHON DAN PENGAJIAN</center></th></thead>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama:</th>
                        <td colspan="5"><?= strtoupper($model->kakitangan->displayGelaran . ' ' . ucwords(strtolower($model->kakitangan->CONm))); ?></td>

                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMSPER:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">No. Kad Pengenalan: </th>
                        <td><?= $model->kakitangan->ICNO; ?></td>  
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon (P):</th>
                        <td><?= ucwords(strtolower($model->kakitangan->COOffTelNo)) ?> (ext. <?= ucwords(strtolower($model->kakitangan->COOffTelNoExtn)) ?>)</td>
                        <th class="col-md-3 col-sm-3 col-xs-12 text-left">No. Telefon (Bimbit): </th>
                        <td><?= ucwords(strtolower($model->kakitangan->COHPhoneNo)) ?></td>  
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Institut Pengajian:</th>
                        <td colspan="5"><?= ucwords(strtoupper($model->study2->InstNm)); ?></td> 

                    </tr>


                   
                    <tr>
                        <th class="col-md-2 col-sm-3 col-xs-12">Bidang Pengajian: </th>
                        <td colspan="5"><?= ucwords(strtoupper($model->study2->major->MajorMinor)); ?></td>  

                    </tr>

                    <tr>
                        <th class="col-md-2 col-sm-3 col-xs-12">Tarikh Lapor Diri: </th>
                        <td colspan="5"></td>  

                    </tr>

                    <tr>
                        <th class="col-md-2 col-sm-3 col-xs-12">Tarikh Lulus Pengajian: </th>
                        <td colspan="5"></td>  

                    </tr>

                </table>
        </div>   </div>  </div>


<div class="x_panel">   <div class="x_content">
        <div>
            <form id="w0" class="form-horizontal form-label-left" action="">

                <table class="table table-bordered jambo_table">
                    <tr>
                    <thead>
                    <th scope="col" colspan=12">
                    <center>PERAKUAN PEMOHON</center></th></thead>

                    <tr class="headings">

                    
                
                        <?php // $model->agree = 0; ?> 
              

                    <td class="col-sm-2 text-center">
                        <div >
                           <?= $form->field($model, 'agree')->checkbox()->label(false); ?>
                            <p class="text-justify"><h5 style="color:black;" ><br> 
                           &nbsp;Saya mengaku segala maklumat dan dokumen yang disertakan adalah benar
                           dan saya bersetuju sekiranya maklumat ini didapati palsu, permohonan ini akan terbatal dan saya
                           boleh dikenakan tindakan tatatertib disebabkan tidak jujur/amanah seperti yang diperuntukkan di dalam
                           Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) 2000 (Akta 605)</p>

                            </h5> 
                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model->tarikh_m; ?></p></center><br/>

                    </div>
                    </td>
              
                
                </table>
        </div> </div></div>
<div class="customer-form">  
    <div class="form-group" align="center">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
            <br>
            <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success'])  ?>
            <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
    </div>
</div>   


<?php ActiveForm::end(); ?>
 


