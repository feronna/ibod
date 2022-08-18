<?php
use yii\helpers\Url;    
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\TblTajaan; 
use app\models\cbelajar\TblBantuan;
use yii\bootstrap\Dropdown;
use app\models\cbelajar\RefBantuan;
$title = $this->title = 'Pembiayaan / Pinjaman';

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
error_reporting(0);
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN SEPARUH MASA
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menusm', ['title' => $title, 'id'=> $iklan->id]) ?>
<div class="col-md-12 col-sm-12 col-xs-12">

<div class="row">

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<!--<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-pemohon']) ?></li>
        <li><?= Html::a('Maklumat Pembiayaan / Pinjaman', ['cbelajar/maklumat-biasiswa-separuh-masa']) ?></li>
        
    </ol>
</div>
  -->
 <div class="x_panel">
 <div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12">JENIS TAJAAN :<span class="required"></span>
</label>
  <div class="col-md-6 col-sm-6 col-xs-12">
        <?php
        echo Html::beginTag('div', ['class'=>'dropdown']);
        echo Html::button('&nbsp Pilih Tajaan &nbsp &nbsp <span class="caret"  ></span>', 
            ['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
        echo Dropdown::widget([
            'items' => [
                ['label' => 'Tajaan Luar', 'url' =>  ['cbelajar/tajaanluarsm', 'id'=>$iklan->id]],
                ['label' => 'Biasiswa Pengurusan UMS', 'url' =>  ['cbelajar/biasiswaumssm', 'id'=>$iklan->id]],
                ['label' => 'Kementerian Pendidikan Tinggi (KPT)', 'url' =>  ['cbelajar/kpmsm', 'id'=>$iklan->id]],
                ['label' => 'Tanpa Tajaan', 'url' =>  ['cbelajar/tanpatajaansm', 'id'=> $iklan->id]],

            ],
        ]); 
        echo Html::endTag('div');
        ?> 
</div> 
 </div>
 </div></div>
<!-- Maklumat Pembiayaan / Pinjaman -->

<div class="x_panel">
<div class="x_content">
<div class="table-responsive" id="tajaan"  style="display: none">
<div class="col-xs-12 col-md-12 col-lg-12">
                  
            <?= $this->render('_tajaanluarsm',[ 'model' => $model2,
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
          ]) ?>
   


          &nbsp;&nbsp;&nbsp;&nbsp;
          

    
            </div>
    </div> 
</div>
</div>
</div>
     <div  id="tanpatajaan" style="display: none" align="center">
         <?php $model->agree = 0; ?>
                <br><?= $form->field($model, 'agree')->checkbox()->label(false); ?> <p>&nbsp;&nbsp;</p>
        <div style="width: 600px; height: 40px;border:3px solid red">
            
            <center><h4> Saya memilih untuk melanjutkan pengajian tanpa sebarang penajaan.</h4></center><br>

        
            </div>
                <br>
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9" align="">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
          </div>
        </div>        
<div id="kpm" style="display: none"><br>
    <strong><p><i>Sila lengkapkan Borang Kementerian Pendidikan Malaysia (KPM) dan muatnaik dokumen tersebut di bahagian menu <a href="senarai-dokumen"><u>"Muat Naik Dokumen"</a></u></i></p></strong><br>

  <div class="table-responsive">

                    <table class="table table-sm jambo_table table-striped"> 
                          <tr>
                              <th>1. Lampiran A2:</th>
                          <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads/cbelajar-cutibelajar/dokumen/4. Lampiran A2 - Borang Kursus Dalam Perkhidmatan SLAB-SLAI-SK-PD.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                                Bahagian Biasiswa dan Pembiayaan</td>
                          
                        </tr>
                     
                   <tr>
                            <th>2. Lampiran A3:</th>
                             <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads/cbelajar-cutibelajar/dokumen/3. Lampiran A3 - COVER DEPAN PENGESAHAN CADANGAN PENYELIDIKAN (Sarjana-PhD-PD-SK).pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> 
                                     Klik Sini Untuk Muat Turun</a><br>Pengesahan Cadangan Penyelidikan</td>
                   </tr>
                   
                   <tr>
                            <th>3. Lampiran A4:</th>
                             <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads/cbelajar-cutibelajar/dokumen/2. Lampiran A4 - BORANG PERAKUAN - PERSEDIAAN CALON PHD (SLAB-SLAI).pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>Borang Perakuan Persediaan Calon PHD

</td>
                   </tr>
    <tr>
                            <th>4. Lampiran A5:</th>
                             <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads/cbelajar-cutibelajar/dokumen/5. Lampiran A5 - CV SLAB_SLAI_SK_PD.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>CV SLAB/SLAI/SK/PD


</td>
                   </tr>
                    </table>
  </div>

      
      
        
</div>
    
   
  

<!--  -->        
<br/>

         
                 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

        <?php ActiveForm::end(); ?>
  
<br/>
<br/>
<p align ="right">
<?= Html::a('Seterusnya', ['cbelajar/maklumat-keluarga-separuh-masa','id'=>$iklan->id], ['class' => 'btn btn-info btn-sm']);?>
<?php echo Html::a('Kembali',['maklumat-pengajian-separuh-masa', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
</p>
</div>










          

   



