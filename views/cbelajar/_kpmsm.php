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
$title = $this->title = 'Pembiayaan / Pinjaman';

?>
<?php echo $this->render('/cutibelajar/separuhmasa/_menusm', ['title' => $title, 'id'=>$iklan->id]) ?>



<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

   
       
<div class="col-xs-12 col-md-12 col-lg-12">
 <div class="x_panel">
       <p align ="right">
               
                <?php echo Html::a('Kembali',['tambah-biasiswa-sm', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
            </p>
     <strong><p><i>Sila lengkapkan Borang Kementerian Pendidikan Malaysia (KPM) dan muatnaik dokumen tersebut di bahagian menu "Muat Naik Dokumen"</i></p></strong><br>
     <i style="color: red;"><b>Permohonan KPT hanya layak diisi sekiranya memiliki Ijazah Sarjana Muda dengan PNGK 3.0 atau Kelas Dua Atas.</b></i>
  <div class="table-responsive">

                    <table class="table table-sm jambo_table table-striped"> 
                          <tr>
                              <th>1. Lampiran A2:</th>
                          <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                  . 'Lampiran A2 - Borang Kursus Dalam Perkhidmatan SLAB-SLAI 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                                A2 Bahagian Biasiswa dan Pembiayaan 
                         </td>
                         <td style="color: green;">
                              <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                      . 'Lampiran A2.1 - Borang Kursus Dalam Perkhidmatan SKPD 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
                                A2.1 Bahagian Biasiswa dan Pembiayaan
                         </td>
                          
                        </tr>
                     
                   <tr>
                            <th>2. Lampiran A3:</th>
                             <td style="color: green;"><a href="
                                 <?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                         . 'Lampiran A3 - COVER DEPAN PENGESAHAN CADANGAN PENYELIDIKAN (PhD-PD) 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> 
                                     Klik Sini Untuk Muat Turun</a><br>A3 Pengesahan Cadangan Penyelidikan</td>
                             <td style="color: green;"><a href="
                                 <?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                         . 'Lampiran A3.1 - COVER DEPAN PENGESAHAN PELAN PENGAJIAN (SARJANA PERUBATAN-SK) 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> 
                                     Klik Sini Untuk Muat Turun</a><br>A3.1 Pengesahan Pelan Pengajian </td>
                   </tr>
                   
                   <tr>
                            <th>3. Lampiran A4:</th>
                             <td style="color: green;"><a href="
                                 <?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                         . 'Lampiran A4 - BORANG PERAKUAN - PERSEDIAAN CALON PHD (SLAB-SLAI) 2021.pdf', true); ?>" 
                                         target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>Borang Perakuan Persediaan Calon PHD

                             </td><td></td>
                   </tr>
    <tr>
                            <th>4. Lampiran A5:</th>
                             <td style="color: green;"><a href="
                                 <?php echo Url::to
                                         ('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                         . 'Lampiran A5 - CV SLAB_SLAI_SK_PD 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>CV SLAB/SLAI/SK/PD


</td>
                   </tr>
                    </table>
  </div>

      
      
        
</div>

<div class="x_panel">
    
<table class="table table-sm table-bordered" >
<thead>
        
        <th scope="col" colspan="6" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PEMBIAYAAN / PINJAMAN</center></th>

                       <!--  <tr>
                            
                            <th valign="top" width ="40%"><center>Nama Tajaan</center></th>
                            <th  width ="40%"><center>Bentuk Bantuan</center></th>
                            <th valign="top" width ="40%"><center>Amaun</center></th>
                            
                        </tr> --> 
        <tr>
                <td valign="top" width ="30%">Nama Agensi/Tajaan:<span class="required" style="color:red;">*</span></td>
                <td colspan="4"> <?= $form->field($model, 'nama_tajaan')->textInput(['readonly' => true, 'value' => 'KEMENTERIAN PELAJARAN MALAYSIA'])->label(false) ?> </td> 
                
                            
        </tr> 

          
                    </thead>
                  
                </table> 
          &nbsp;&nbsp;&nbsp;&nbsp;
             
  <div class="form-group">
      <p align ="right">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        
      </p>
        </div>

    </div>
</div>

        <?php ActiveForm::end(); ?>
  
  



