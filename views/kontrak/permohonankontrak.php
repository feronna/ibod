<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

error_reporting(0);
$bil=1;

?>

<?= $this->render('/kontrak/_topmenu') ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Pelantikan Semula Kontrak</h2>
            <div class="clearfix"></div>
        </div>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'icno')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
        
        <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="col-md-10 col-sm-10 col-xs-12">
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
              
            </div>
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($model, 'startdatelantik')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($model, 'enddatelantik')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Perkhidmatan<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($model, 'tempoh')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Permohonan Pelanjutan Kali Ke <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?php echo $countlantikan?>" disabled="disabled">
                </div>
        </div>
    </div>
        </div>
    </div>
</div>
        <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Senarai Lantikan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Status Lantikan</th>
                    <th class="text-center">Tarikh Mula Lantikan</th>
                    <th class="text-center">Tarikh Tamat Lantikan</th>
                </tr>
                </thead>
                <?php 
                if ($lantikan) { ?>
                    <?php foreach ($lantikan as $l) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $l->statusLantikan->ApmtStatusNm; ?></td>
                            <td class="text-center"><?php echo $l->tarikhmulalantikan; ?></td>
                            <td class="text-center"><?php echo $l->tarikhtamatlantikan; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
</div>
       
    <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Laporan Nilaian Prestasi Tahunan (LNPT)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <?= Html::a('<i class="fa fa-eye"></i> SKT '.date('Y')-1, ['skt-bahagian1', 'icno' => $model->icno, 'tahun' => date('Y')-1], ['class'=>'btn btn-primary', 'target' => '_blank']) ?>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Markah Purata</th>
                </tr>
               </thead>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-1; ?></td>
                            <td class="text-center"><?= $model->markahlnpt(date('Y')-1); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-2; ?></td>
                            <td class="text-center"><?= $model->markahlnpt(date('Y')-2); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-3; ?></td>
                            <td class="text-center"><?= $model->markahlnpt(date('Y')-3); ?></td>
                        </tr>
            </table>
            </div>
        </div>
    </div>
</div>
        
   <?= $this->render('d_idp', ['model' => $model])?>
        
 <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Senarai Anugerah</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Nama Anugerah</th>
                    <th class="text-center">Gelaran</th>
                    <th class="text-center">Dianugerahkan Oleh</th>
                    <th class="text-center">Kategori</th>
                </tr>
               </thead>
                <?php
                if ($anugerah) { $bil1=1;?>
                    <?php foreach ($anugerah as $l) {?>
                        <tr>
                             <td class="text-center"><?php echo $l->namaAnugerah->Awd; ?></td>
                            <td class="text-center"><?php echo $l->gelaran->Title; ?></td>
                            <td class="text-center"><?php echo $l->dianugerahkanOleh->CfdBy; ?></td>
                            <td class="text-center"><?php echo $l->kategoriAnugerah->AwdCat; ?></td>
                        </tr>
                   
                <?php } }?>
            </table>
    </div>
        </div>
    </div>
</div>
        
  <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Laporan Kehadiran Tahunan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Lambat</th>
                    <th class="text-center">Tidak Lengkap</th>
                    <th class="text-center">Tidak Hadir</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                <?php
                    for($i=0; $i<=2 ; $i++){
                      $tahun = date('Y')-$i; ?>
                          <tr>
                            <td class="text-center"><?= $tahun ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1)?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 3) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 4) ?></td>
                            <td class="text-center"><?= $model->kehadiran($tahun, 1) +
                            $model->kehadiran($tahun, 3)+ 
                            $model->kehadiran($tahun, 4)
                            ?></td>
                        </tr><?php 
                    }
                ?>
                        
            </table>
        </div>
        </div>
    </div>
</div>
        
        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Justifikasi permohonan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'reason')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tarikhmohon')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <?php if($model->dokumen_sokongan!= NULL){?>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan.pdf</u></a><br>
                    
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
        
       <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Persetujuan Ketua Pentadbiran</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Persetujuan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->viewstatuspp;?>" disabled="disabled">
                </div>
            </div>
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tempoh Lantikan Semula Kontrak<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" class="form-control" value="<?php echo $model->tempoh_l_pp;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_pp')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhpp;?>" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
         </div>
            
      <div class="row" > 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->viewstatusjfpiu;?>" disabled="disabled">
                </div>
            </div>
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tempoh Lantikan Semula Kontrak<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" class="form-control" value="<?php echo $model->tempoh_l_jfpiu;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhkj;?>" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
         </div>
        
         <div class="row" > 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Kelulusan BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->viewstatusbsm;?>" disabled="disabled">
                </div>
            </div>
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Lantikan Semula Kontrak<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <input type="text" class="form-control" value="<?php echo $model->tempoh_l_bsm;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhlulus;?>" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
         </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


