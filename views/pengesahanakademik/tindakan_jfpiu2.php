<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\pengesahan\Pengesahan;
use yii\helpers\ArrayHelper;
error_reporting(0);
?>
<?= $this->render('/pengesahan/_topmenu') ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="row">   
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Pengesahan Dalam Perkhidmatan</h2>&nbsp;
                 
                <?php
                echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i> Lihat CV', [ 'cv/view-cv',  'id' => sha1($model->icno),
                    'title' => 'personal',], [
                    'class' => 'btn btn-primary btn-sm',
                    'target' => '_blank',
                ]);
                ?>
            
            <div class="clearfix"></div>
        </div>

<div class="row">   
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS (PER) <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
  
<div class="row">        
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gred & Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>
            <div class="form-group">  
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>   
            </div>
             <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Program <span class="required"></span></label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" value="<?php echo $model->kakitangan->programPengajaran->NamaProgram.' ('.$model->kakitangan->programPengajaran->KodProgram.')'?>" disabled="disabled">
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengesahan Dalam Perkhidmatan<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->confirmation->statusPengesahan, 'ConfirmStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan Jawatan Tetap<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model, 'startdatelantik')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Perkhidmatan Lantikan Tetap Semasa Permohonan Dikemukakan<span class="required"></span> 
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                   <?= $form->field($model->kakitangan, 'servPeriodPermanent')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>  
        </div>
        </div>
    </div>
</div>
</div>
 
<!--<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pengajaran</strong></h2>
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
                    <th class="text-center">Kod Kursus</th>
                    <th class="text-center">Tajuk Kursus</th>
                    <th class="text-center">Semester</th>    
                    <th class="text-center">Bil. Pelajar</th>
                    <th class="text-center">Bil. Jam Per Semester</th>
                </tr>
                </thead>         
                        <php
                            if ($model->pengajaran) { $bil1=1;?>
                                <php foreach ($model->pengajaran as $l) { $bil1++;
                                        ?>
                                <tr>
                                    <td class="text-center"><= $l->SMP07_KodMP; ?></td>
                                    <td class="text-center"><= $l->NAMAKURSUS; ?></td>        
                                    <td class="text-center"><= $l->SESI; ?></td>
                                    <td class="text-center"><= $l->BILPELAJAR; ?></td>
                                    <td class="text-center"><= $l->JAMKREDIT; ?></td>
                                </tr>
                                <php } }?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Penyelidikan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
               <= $this->render('_penyelidikan',['model'=>$model,]) ?>
        </div>
    </div>
</div>
</div>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Artikel Dalam Jurnal Berwasit</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
                    <= $this->render('_artikelberwasit',['model'=>$model,]) ?>
        </div>
    </div>
</div>
</div>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Artikel Prosiding</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
                    <= $this->render('_artikelprosiding',['model'=>$model,]) ?>
        </div>
    </div>
</div>
</div>
  
<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Penerbitan Akademik Lain</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
                    <= $this->render('_penerbitan',['model'=>$model,]) ?>
        </div>
    </div>
</div>
</div>-->

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Rekod Tatatertib</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Tarikh Mesyuarat</th>
                    <th class="text-center">Tarikh Mula Hukuman</th>
                    <th class="text-center">Tarikh Akhir Hukuman</th>
                    <th class="text-center">Status Kes</th>
                </tr>
                </thead>         
                 <?php
                if ($tatatertib) { $bil1=1;?>
                    <?php foreach ($tatatertib as $tatatertib) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $tatatertib->tarikh_mesyuarat; ?></td>
                             <td><?= $tatatertib->tarikh_mula_hukuman; ?></td>
                             <td><?= $tatatertib->tarikh_akhir_hukuman; ?></td>
                             <td><?= $tatatertib->status_kes; ?></td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
 </div>
</div>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Permohonan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>    
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Tarikh Permohonan</th>
<!--                    <th class="text-center">Status</th>        -->
                    <th class="text-center">Cadangan Tempoh Ketua Jabatan</th>
                    <th class="text-center">Cadangan Tempoh BSM</th>
<!--                    <th class="text-center">Cadangan Tarikh Mohon</th>-->
                </tr>
                </thead>         
                 <?php
                if ($status) { $bil1=1;?>
                    <?php foreach ($status as $statuss) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $statuss->tarikhmohon; ?></td>
<!--                             <td><?= $statuss->statuss; ?></td>      -->
<!--                             <td><?= $statuss->tempoh_l_jfpiu; ?></td>  -->
                             <td><?php if($model->tempoh_l_jfpiu!= NULL){?>               
                                 <?php echo $model->tempoh_l_jfpiu;?>
                                 <?php }else{ echo "Tidak Berkaitan"; }?>
                             </td>
<!--                              <td><?= $statuss->tempoh_l_bsm; ?></td>    -->
                             <td><?php if($model->tempoh_l_bsm!= NULL){?>               
                                 <?php echo $model->tempoh_l_bsm;?>
                                 <?php }else{ echo "Tidak Berkaitan"; }?>
                             </td>
<!--                              <td><?= $statuss->tarikhmohonbalik; ?> - <?= $statuss->tarikhmohonbalik2; ?></td>  -->

                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Adakah anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP) atau Skim Pencen?<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'skim')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group" id="file2">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen KWSP/PEMBERIAN TARAF BERPENCEN<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan2!= NULL){?>                   
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 1.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus Program Transformasi Minda/Kursus Induksi<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->tarikh_lulus_ptm!= NULL){?>
                    <?= $form->field($model, 'tarikhlulusptm2')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                    <?php }else{
                    echo $form->field($model->kakitangan2, 'tarikhlulusptm')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); }?>
                </div>
            </div>
            <div class="form-group" id="file">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Sijil Lulus Program Transformasi Minda/Kursus Induksi<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan!= NULL){?> 
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 2.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kursus Kaedah Pengajaran & Pembelajaran<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tarikhluluspnp')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group" id="file3">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Sijil Kursus Kaedah Pengajaran & Pembelajaran<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan3!= NULL){?> 
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan3), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 3.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>
            <div class="form-group" id="file3">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Salinan Kad Pengenalan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->dokumen_sokongan5!= NULL){?> 
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan5), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan 5.pdf</u></a><br>
                    <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                </div>
            </div>     
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tarikhmohon')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
        
<div class="row" style="display: <?php if(Yii::$app->user->getId() === $model->app_by && $model->status === 'DALAM TINDAKAN KETUA JABATAN'){echo 'none';}?>">  
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_jfpiu;?>" disabled="disabled">
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required"></span>
                </label>             
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php if($model->tempoh_l_jfpiu!= NULL){?>
                    <input type="text" class="form-control" value="<?php echo $model->tempoh_l_jfpiu;?>" disabled="disabled">
                    <?php }else{
                        echo "Tiada Berkaitan";
                    }?>
                </div>
                
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diperaku<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhkj;?>" disabled="disabled">
                </div>
            </div>    
        </div>
    </div>
</div>
</div>
        
<div class="row" style="display: <?php if(Yii::$app->user->getId() !== $model->app_by || (Yii::$app->user->getId() === $model->app_by&&$model->status != 'DALAM TINDAKAN KETUA JABATAN')){echo 'none';}?>">  
<div class="col-md-12 col-sm-12 col-xs-12">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakui' => 'PERMOHOHAN DIPERAKUI', 'Tidak Diperakui' => 'PERMOHONAN DITOLAK'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Diperakui"){
                        $("#tempoh").hide();
                        }
                        else{
                        $("#tempoh").show();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
        </div>
        <div class="form-group" id="ulasan">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        <div class="form-group" id="tempoh" style="display: none">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?php
                    $tempoh =ArrayHelper::map(\app\models\Pengesahan\RefTempoh::find()->where(['id' =>2])->orWhere(['id' =>3])->orWhere(['id' =>4])->all(), 'tempoh', 'tempoh');
                    ?>
                    <?=
                    $form->field($model, 'tempoh_l_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => $tempoh,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "LAIN-LAIN"){
                        $("#place-holder").show();
                        }
                        else{
                        $("#place-holder").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    <div class="col-md-3 col-sm-3 col-xs-12" style="display: inline">
                        <input type="number" id="place-holder" name="tempohs" class="form-control" maxlength="20" style="display: none" placeholder="bulan    cth: 6">
                    </div>                 
                </div>
        </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                     <?= Html::a('<i class="fa fa-arrow-left"></i> Kembali', ['tindakan_jfpiu1', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                      <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
    </div>
</div>
            <?php ActiveForm::end(); ?>
</div>
        
</div>
</div>
</div>
