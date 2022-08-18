<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\kemudahan\Reftujuan; 
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\hronline\HubunganKeluarga;
use app\models\cbelajar\TblPrestasi;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;    


error_reporting(0); 
?>
<?php $this->title = 'Borang Online';?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

   <?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
   <?php 
//              //  echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['/lanjutancb/cetak-permohonan', 'i'=>$model->id,
//                   'id'=> $model->iklan_id, 'target'=>'_blank'], [
//                    'class'=>'btn btn-primary btn-sm', 
//                    'target'=>'_self', 
//                    'data-toggle'=>'tooltip', 
//                    'title'=>'Permohonan Pelanjutan Tempoh Cuti Belajar'
//                ]);
    //            ?>
<div class="pull-right">
             <?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?>
    </div> 

<div class="x_panel">
    
        <div class="x_content">  
         
            <span class="required" style="color:#062f49;">
               
                <center> <h2><strong><?= strtoupper('
     PERMOHONAN PELANJUTAN TEMPOH CUTI BELAJAR 
 '); ?>
                        </strong></h2> </center>
            </span> 
        </div>
    </div>
<div class="x_panel">
        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <div align="justify">
            o PERMOHONAN INI HENDAKLAH DIKEMUKAKAN DUA BULAN (60 HARI) SEBELUM TAMAT TEMPOH CUTI BELAJAR/ PELANJUTAN YANG
            TERDAHULU DAN MESTILAH LENGKAP DILAMPIRKAN DENGAN DOKUMEN YANG DISENARAIKAN. <br></div>
            <div align="justify">
                    o PERMOHONAN INI HENDAKLAH DIKEMUKAN BERSAMA-SAMA DENGAN DOKUMEN (WAJIB) BERIKUT:<br>
                   
                    <ul> 1. PERANCANGAN PENGAJIAN (STUDY PLAN) TERDAHULU.<br>
                         2. PERANCANGAN PENGAJIAN YANG DIUBAHSUAI MENGAMBIL KIRA TEMPOH PELANJUTAN YANG DIPOHON.<br>
                         3. LAPORAN KEMAJUAN PENGAJIAN (LKP) DAN TRANSKRIP KEPUTUSAN PEPERIKSAAN<br></ul> </div>
            
        </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
               [KLIK] SENARAI LAPORAN KEMAJUAN PENGAJIAN (LKP) YANG PERLU DIHANTAR
                  <?= Html::a('LAPORAN KEMAJUAN PENGAJIAN', ['lkk/senarailkk'], 
         ['class' => 'btn btn-danger btn-sm','target' => "_blank"]) ?> </strong> 
            </span> 
        </div>
</div>  </div></div>    



       <div class="x_panel">
<div class="x_content">
<div class="x_title">
   <h5><strong><i class="fa fa-th-list"></i> MAKLUMAT PELANJUTAN</strong></h5>
   <strong><i>Sila Kemaskini Justifikasi Permohonan Pelanjutan Sebelum Ini.</i></strong>
   <div class="clearfix"></div>
</div>

<form id="w0" class="form-horizontal form-label-left">
            <table class="table table-sm table-bordered">
   <thead>
       
        <tr class="headings">
          <th width="50px" height="20px">BIL</th>
            <th>TARIKH PELANJUTAN CUTI BELAJAR </th>
            <th class="column-title text-center">TEMPOH </th>
            <th class="column-title text-center">PELANJUTAN KALI KE</th>
            <th class="column-title text-center">JUSTIFIKASI</th>
            <th class="column-title text-center">TINDAKAN</th>

        </tr>
        
        
        

    </thead>
 <tbody>
        
         <?php if($b->lanjutan){ ?>
        <?php $bil=1; foreach ($b->lanjutan as $l) { ?>
<tr>
<td class="text-center"><?= $bil++ ?></td>
<td> <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?></td>
<td class="text-center">

<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?></td>
 </td>
<td class="text-center"><?= $l->idlanjutan; ?></td>
<td class="text-center"><?= $l->justifikasi; ?></td>
<td class="text-center">  <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['cbadmin/kemaskini-lanjutan', 'id' => $l->id]),
                     'class' => 'btn btn-default btn-xs mapBtn']) ?></td>
</tr>
        <?php }} else{
                    ?>
                    <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
                  <?php  
                } ?>
                        
                    
         
        
        

 </tbody>

 </table>
</form>          
</div>
</div><?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

       <div class="x_panel">
<div class="x_title">
   <h5><strong><i class="fa fa-user"></i> MAKLUMAT PEMOHON</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="x_content">
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
<!--                                     <th scope="col" colspan=12"  style="background-color:white;"><center>MAKLUMAT PEMOHON</center></th>-->

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. PEKERJA:</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. KAD PENGENALAN:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT (TERKINI):</th>
                        <td> <?= $form->field($model, 'alamat')->textArea(['maxlength' => true]) ->label(false);?> 
</td> 
                    </tr>
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. TELEFON:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">PERINGKAT PENGAJIAN:</th>
                        <td><?= ucwords(strtoupper($b->pendidikanTertinggi->HighestEduLevel)); ?></td> 
                    </tr>
                 
                    <tr> 
                                  <?php  if(!$b->l){
                                 ?> 
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI:</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($b->InstNm); ?></td><?php }?></tr>
                        
                        
                        <?php  if($b->l){  ?> 
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN ASAL:</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->InstNm; ?>
                          
   
                      
                        </td>
                    </tr>
                    <tr> 
                            
                                  
                               
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN BAHARU:</th>
                        <td style="width:20%">
                            
                         <?php  echo $b->l->renewTempat; ?>
                          
   
                      
                        </td>
                  
                       
                            
                                  
                               
                        
                            <?php }?></tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">BIASISWA:</th>
                        <td><?= ucwords(strtoupper($b->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                     <tr>
                            <th width="25%">JFPIB: </th>
                            <td width="85%"><?=  ucwords(strtoupper($b->kakitangan->displayDepartment)) ?></td>  
                     </tr>
                    
                     

                    
                    

                     
                </table>
            </div>  </div>  </div>

<div class="x_panel">   
    <div class="x_content">
        <div class="x_title">
   <h5><strong><i class="fa fa-bar-chart"></i> MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
<div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped "> 
                    <tr>
<!--                    <th scope="col" colspan=12"  style="background-color:white;"><center>MAKLUMAT PRESTASI PENGAJIAN (TERKINI)</center></th>-->

                     </tr>
                     <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center" width="40%">PERKARA</th>
                        <th class="column-title text-center">PERATUSAN/ TARIKH/ BILANGAN</th>
                    </tr>
                     <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;">PENYELIDIKAN:</th>
                    
                </tr>
             <?php
                            if ($doktoral) 
                            { $no=0;?>
                            
                                <?php foreach ($doktoral as $dok) { 
                                    
                                    if($dok->id < 7)
                                    {
                                        
                                  
                                    
                                    $no++; 
                                $mod = \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id])->exists()?
                                      \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id])->one():new TblPrestasi();
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-justify"><input type="text" id="tblprestasi-catatan" class="form-control" name="<?= $dok->id?>">

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                }}?>
                 <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;">KERJA KURSUS:</th>
                    
                </tr>
                
                     <?php foreach ($doktoral as $dok) { 
                                    if($dok->id >= 7)
                                    {
                                  
                                    $no++; 
$mod = \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id])->exists()?
                                      \app\models\cbelajar\TblPrestasi::find()->where(['id' => $dok->id])->one():new TblPrestasi();                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->prestasi; ?></td>
                                    <td class="text-justify"><input type="text" id="tblprestasi-catatan" class="form-control" name="<?= $dok->id?>"> 

                                   
                                </tr>
                                
                                
                                    <?php 
                                    
                                    }
                                    }
                               
//                             }
                            }
                            ?>

                   
            

                    
                    

                     
                </table>
</div> </div></div>
<!--
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                 SILA KEMASKINI LAPORAN KEMAJUAN KURSUS TERKINI ANDA DISINI
                  <?Html::a('LAPORAN KEMAJUAN KURSUS', ['lkk/senarailkk'], 
         ['class' => 'btn btn-primary btn-sm','target' => "_blank"]) ?> </strong> 
            </span> 
        </div>
    </div>  -->
<div class="x_panel">
<!--        <div class="x_title">
           
            <div style=" background-color: #E8E5E4; width:1034px;height:30px;border:0px solid #000;"><h2><strong>&nbsp;MAKLUMAT PEMOHON</strong></h2> </div>
                    <div class="clearfix"></div>
        </div>-->
        <div class="x_content">
            <div class="x_title">
   <h5><strong><i class="fa fa-plus-square"></i> PERMOHONAN PELANJUTAN</strong></h5>
   
   
   <div class="clearfix"></div>
</div>
        <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                     <th scope="col" colspan=12"  style="background-color:white;"><center>PELANJUTAN BAHARU YANG DIPOHON</center></th>

                 
                   
                  <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MULA PELANJUTAN:</th>
                        <td>  <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'lanjutansdt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>  </td>
</td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT PELANJUTAN:</th>
                        <td>  <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'lanjutanedt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>  </td>
</td> 
                    </tr>
                <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JUSTIFIKASI PELANJUTAN:</th>
                        <td> <?= $form->field($model, 'justifikasi')->textArea(['maxlength' => true]) ->label(false);?></td>
</td> 
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">SURAT SOKONGAN DAN PERAKUAN PENYELIA:<br><a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/EDARAN-BORANG-PERMOHONAN-PELANJUTAN-TEMPOH-2019-3.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a></th>
                        <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN (STUDY PLAN) TERDAHULU:</th>
                        <td class="text-justify"><?= $form->field($model, 'file3')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                
                  <tr class="headings">
                      <th class="col-md-3 col-sm-3 col-xs-12">PERANCANGAN PENGAJIAN YANG DIUBAHSUAI:<br>
                          <small><i>MENGAMBIL KIRA TEMPOH PELANJUTAN YANG DIPOHON</i></small></th>
                        <td class="text-justify"><?= $form->field($model, 'file4')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>
                    <?php if($b->tajaan->jenisCd == 3)
{?>
            <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">BORANG PERMOHONAN PELANJUTAN BIASISWA KPT<br>
                            <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/Borang Pelanjutan KPT 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a></th>
                         </th>
                        <td class="text-justify"><?= $form->field($model, 'file5')->fileInput()->label(false);?> </td>
                        

<?php }?>          
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">LAPORAN KEMAJUAN PENGAJIAN (LKP)<br>
                            <small style="color: red;">YANG TERKINI*</small></th>
                        <td class="text-justify"><span class="required" style="color:#062f49;">
                <?php if($lkk){
                    if(!$lkk->status_bsm == "Admin Manually Upload")
                    {
                    
                    echo '<i class="fa fa-check  fa-lg aria-hidden="true"   style="color: green"></i> <small>TELAH DIHANTAR</small>'. 
                   ' ['. $lkk->tarikh_mohon. ']';
                    }
                    else
                    {
                          echo '<i class="fa fa-check  fa-lg aria-hidden="true"   style="color: green"></i> <small>TELAH DIHANTAR</small>'. 
                   ' ['. $lkk->tarikh_hantar. ']';  
                    }
                    
//                    echo "submitted". $lkk->;
                } else{
?>                <small> <strong>
                  [KLIK]
                  <?= Html::a('LAPORAN KEMAJUAN PENGAJIAN', ['lkk/senarailkk'], 
                ['class' => 'btn btn-primary btn-xs','target' => "_blank"]) ?><?php }?> </strong> </small>
            </span>  </td>
                        

                        
                    </tr>
                    <tr class="headings">
                        <th class="col-md-3 col-sm-3 col-xs-12">TRANSKRIP KEPUTUSAN PEPERIKSAAN:<br>
                            <small style="color: red;">YANG TERKINI*</small></th>
                        <td class="text-justify"><?= $form->field($model, 'file2')->fileInput()->label(false);?> </td>
                        

                        
                    </tr>

                </table>
            </div>  
      
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])?>
                    <button class="btn btn-warning" type="reset">Reset</button>
                    <?= Html::a('Keluar', ['cutibelajar/halaman-utama-pemohon'], ['class' => 'btn btn-danger ']);?>

                </div>
                </div>
            </div> 
                    <?= $form->field($model, 'HighestEduLevelCd')->hiddenInput(['value' => $study->HighestEduLevelCd])->label(false); ?>
                    <?php 
                    
                    if($l->idLanjutan == 1)
                    {
                    echo $form->field($model, 'idLanjutan')->hiddenInput(['value' => $model->idLanjutan = 2])->label(false);}
                        
                        elseif ($l->idLanjutan == 2)
                        {
                         echo $form->field($model, 'idLanjutan')->hiddenInput(['value' => $model->idLanjutan = 3])->label(false);}

                        elseif($l->idLanjutan == NULL)
                        {
                         echo $form->field($model, 'idLanjutan')->hiddenInput(['value' => $model->idLanjutan = 1])->label(false);}
                        
                        
                        ?>

                    

       </div>  </div>
      
            <?php ActiveForm::end(); ?>
 


 