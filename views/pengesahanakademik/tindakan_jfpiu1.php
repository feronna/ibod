<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\pengesahan\Pengesahan;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblWarnaKad;
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
<!--            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Perkhidmatan Semasa Permohonan Dikemukakan<span class="required"></span> 
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                   <?= $form->field($model, 'tempoh')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>  -->
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

<div class="row">   
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Pendidikan (SPM dan Setaraf)</strong></h2>
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
                    <th class="text-center">Subjek</th>
                    <th class="text-center">Gred</th>    
                    <th class="text-center">Sijil Pelajaran Malaysia</th>
                </tr>
                </thead>         
                <?php
                if ($subjek) { $bil1=1;?>
                    <?php foreach ($subjek as $subjekkakitangan) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekkakitangan->subjek; ?></td>
                             <td><?= $subjekkakitangan->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '14'])->one()->displayLink ?></td>   
                        </tr>
                <?php } }?>
                        
                <?php } else if ($subjek2) { $bil1=1;?>
                        <?php foreach ($subjek2 as $subjekkakitangan2) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                             <td><?= $subjekkakitangan2->subjek; ?></td>
                             <td><?= $subjekkakitangan2->gred; ?></td>  
                             <td><?= \app\models\hronline\Tblpendidikan::find()->where(['ICNO' => $model->icno, 'HighestEduLevelCd' => '23'])->one()->displayLink ?></td>   
                        </tr>
                <?php }}} ?>
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
            <h2><strong><i class="fa fa-book"></i> Anugerah</strong></h2>
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
<!--                    <th class="text-center">Kategori</th>-->
                    <th class="text-center">Nama Anugerah</th>
<!--                    <th class="text-center">Singkatan Anugerah</th>
                    <th class="text-center">Gelaran</th>-->
                    <th class="text-center">Dianugerahkan Oleh</th>         
<!--                    <th class="text-center">Negara</th>
                    <th class="text-center">Negeri</th>-->
                    <th class="text-center">Tarikh Dianugerahkan</th> 
                    <th class="text-center">Sebab Anugerah</th> 
<!--                    <th class="text-center">Status Anugerah</th> -->
                </tr>
               </thead>
                <?php
                if ($anugerah) { $bil1=1;?>
                    <?php foreach ($anugerah as $a) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
<!--                            <td class="text-center"><?php echo $a->kategoriAnugerah->AwdCat; ?></td>-->
                            <td class="text-center"><?php echo $a->namaAnugerah->Awd; ?></td>
<!--                            <td class="text-center"><?php echo $a->AwdAbbr; ?></td>
                            <td class="text-center"><?php is_null($a->gelaran) ? 'Tidak Berkaitan' : $a->gelaran->Title ; ?></td>-->
                            <td class="text-center"><?php echo $a->dianugerahkanOleh->CfdBy; ?></td> 
<!--                            <td class="text-center"><?php is_null($a->negara) ? 'Tidak Berkaitan' : $a->negara->Country; ?></td>
                            <td class="text-center"><?php is_null($a->negeri) ? 'Tidak Berkaitan' : $a->negeri->State; ?></td>-->
                            <td><?php echo $a->awdcfddt; ?></td>
                            <td><?php echo $a->AwdReason; ?></td>
<!--                            <td><?= $a->AwdStatus ? 'Aktif' : 'Tidak Aktif'; ?></td>                        -->
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
            <h2><strong><i class="fa fa-book"></i> Penglibatan Dalam Aktiviti Semasa Di UMS</strong></h2>
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
                    <th class="text-center">Peringkat</th>
                    <th class="text-center">Jenis Kompetensi</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Tarikh</th>
                    <th class="text-center">Tempat</th>                          
                </tr>
               </thead>
                <?php
                if ($latihan) { $bil1=1;?>
                    <?php foreach ($latihan as $l) { 
                        if ($l->senarailatihan->vcsl_tkh_mula >= $model->kakitangan->startDateLantik &&
                                $l->senarailatihan->vcsl_tkh_mula <= $model->kakitangan->endDateLantik) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_peringkat; ?></td>
                            <td class="text-center"><?php echo $l->jeniskompetensi->vcks_nama_kompetensi; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_latihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->tarikhmulalatihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_tempat; ?></td>
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
            <h2><strong><i class="fa fa-book"></i> Markah Penilaian Prestasi Tahunan(LNPT)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>  
        </div>
        <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                    <tr class="headings">
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Markah</th>
                    </tr>
               </thead>
<!--                    <tr>
                        <td class="text-center"><php echo date('Y')-1; ?></td>
                        <td class="text-center"><= $model->markah1->purata; ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><php echo date('Y')-2; ?></td>
                        <td class="text-center"><= $model->markah2->purata; ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><php echo date('Y')-3; ?></td>
                        <td class="text-center"><= $model->markah3->purata; ?></td>
                    </tr>-->
            
                        <?php 
                            $i =0; $jumlahKeseluruhan1 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                            //markah tahun 2019 dan ke bawah (beza tbl c cleeve x guna tbl lama tu yg markah 2020 berbeza tempat)
                            $markahOld = \app\models\elnpt\elnpt_lama\TblUser::find()->where(['user_id' => $model->icno])->one();

                            $recordOld = \app\models\elnpt\elnpt_lama\TblMarkahLama::find()->where(['staff_id' => $markahOld->staff_id, 'tahun' => $t])->orderBy(['id' => SORT_DESC])->one();
                            if ($recordOld) {
                                    if ($recordOld->purata != '0' || $recordOld->purata != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $t; ?></td>
                                            <td class="text-center"><?= number_format($recordOld->purata, 2, '.', ''); ?></td>
                                        </tr>
                                        <?php
                                        
                                        $jumlahKeseluruhan1 = $jumlahKeseluruhan1 + $recordOld->purata;
                                        $i++;
                                    }
                                }
                            }

                        ?> 

                        <?php
                            $j =0; $jumlahKeseluruhan2 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                            //markah tahun 2020 dan ke atas
                            $markah = \app\models\elnpt\TblMain::find()->where(['PYD' => $model->icno, 'PPP_sah' => 1, 'PPK_sah' => 1, 'PEER_sah' => 1, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one(); // yang telah disahkan sahaja

                            $record = \app\models\elnpt\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                            if ($record) {
                                    if ($record->markah != '0' || $record->markah != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $t; ?></td>
                                            <td class="text-center"><?= $record->markah; ?></td></tr>
                                        <?php
                                        
                                        $jumlahKeseluruhan2 = $jumlahKeseluruhan2 + $record->markah;
                                        $j++;
                                    }
                                }
                            }

                        ?> 

                        <?php
                            $k =0; $jumlahKeseluruhan3 = 0;
                            for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                            //akademik yg isi borang pentadbiran
                            $markahPen = \app\models\lppums\Lpp::find()->where(['PYD' => $model->icno, 'tahun' => $t])->orderBy(['tahun' => SORT_DESC])->one();

                            $recordPen = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markahPen->lpp_id])->one();
                            if ($recordPen) {
                                    if ($recordPen->markah_PP != '0' || $recordPen->markah_PP != '') {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $t; ?></td>
                                            <td class="text-center"><?= $recordPen->markah_PP; ?></td></tr>
                                        <?php
                                        
                                        $jumlahKeseluruhan3 = $jumlahKeseluruhan3 + $recordPen->markah_PP;
                                        $k++;
                                    }
                                }
                            }

                        ?> 
                    <tr class="headings">
                        <th class="text-center">Purata Markah</th>
                        <th class="text-center">
                            <?php
                                $jumlahTahun = $i + $j + $k;
                                $purata = number_format(($jumlahKeseluruhan1 +$jumlahKeseluruhan2 + $jumlahKeseluruhan3) / $jumlahTahun , 2, '.', '');

                                echo $purata;
                            ?>
                        </th>
                    </tr>
            </table>
        </div>
        </div>
    </div>
</div>
</div>

<!--<div class="row">   
<div class="col-md-12 col-sm-12 col-xs-12">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>Laporan Kehadiran Tahunan</strong></h2>
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
                    <th class="text-center">Lambat Masuk</th>
                    <th class="text-center">Awal Keluar</th>
                    <th class="text-center">Tidak Lengkap</th>
                    <th class="text-center">Tidak Hadir</th>
                    <th class="text-center">External</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                <php for($i=0; $i<=2 ; $i++){
                ?>
                        <tr>
                            <td class="text-center"><= (date('Y')-$i) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 1) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 2) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 3) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 4) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 5) ?></td>
                            <td class="text-center"><= Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 4) +
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 3)+ 
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 2)+
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 1)+
                            Pengesahan::countKetidakpatuhan($model->icno, (date('Y')-$i), 5)
                            ?></td>
                        </tr>
                <php } ?>
            </table>
        </div>
            <div class="form-group">
                    <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::a('<i class="fa fa-arrow-right"></i> Seterusnya', ['tindakan_jfpiu2', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>-->

<!--<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
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
            <div class="form-group">
                <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::a('<i class="fa fa-arrow-right"></i> Seterusnya', ['tindakan_jfpiu2', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>-->
                            
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Laporan Kehadiran Tahunan</strong></h2>
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
                            <tr>
                                <th class="text-center" rowspan="2" >Year</th>
                                <th class="text-center" colspan="3">Color Card</th> 
                                <th class="text-center" rowspan="2">Achievement</th> 
                            </tr> 
                            <tr> 
                                <th class="text-center" style="background-color:yellow; color:black">YELLOW</th> 
                                <th class="text-center" style="background-color:green; color:black">GREEN</th> 
                                <th class="text-center" style="background-color:red; color:black" >RED</th> 
                            </tr> 
                            <?php
                            for ($i = 0; $i <= 2; $i++) {
                                $tahun = date('Y') - $i;
                                ?>
                                <tr>
                                    <td class="text-center"><?= $tahun ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'YELLOW') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'GREEN') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'RED') ?></td> 
                                    <td class="text-center"><?= TblWarnaKad::prestasiWarnaKad2($tahun, $biodata->ICNO) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                </table>
            </div>
            <div class="form-group">
                <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::a('<i class="fa fa-arrow-right"></i> Seterusnya', ['tindakan_jfpiu2', 'id'=>$model->id], ['class'=>'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

 
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

