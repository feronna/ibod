<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
$this->title = 'Permohonan Cuti Belajar'; 
error_reporting(0);
?>

 <div class="x_panel">
        <div class="x_content"> 
      
              <p align="center"><strong>UNIT PENGAJIAN LANJUTAN | SEKTOR PEMBANGUNAN SUMBER MANUSIA</strong></p> 
              <p align="center"><strong><u>SEMAK SYARAT CUTI BELAJAR - LATIHAN INDUSTRI</u></strong></p> 
             
        </div>
    </div>
  <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">  
     <div class="x_panel">
          <div class="x_title">
                   
              <font size="2"> <center><strong>MAKLUMAT KAKITANGAN</strong></center>
                     
                    <div class="clearfix"></div>
                </div>
    <table class="table table-sm table-bordered">

                   <tr>
                    <td width="15%"><font size="2"><strong>Nama Pegawai</strong></td>
                    <td><font size="2"><?= $kontrak->kakitangan->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong><font size="2">No. KP / Pasport</strong></td>
                    <td><font size="2"><?= $kontrak->kakitangan->ICNO; ?></td>
                </tr>

                  <tr>
                    <td><font size="2"><strong>JSPIU</strong></td>
                    <td><font size="2"><?= $kontrak->kakitangan->department->fullname; ?></td>
                </tr>
                <tr>
                    <td><font size="2"><strong>Jawatan / Gred</strong></td>
                    <td><font size="2"><?= $kontrak->kakitangan->jawatan->nama; ?> / <?= $kontrak->kakitangan->jawatan->gred; ?></td>
                </tr>
                <tr>
                    <td><font size="2"><strong>Peringkat Pengajian Yang Dipohon</strong></td>
                    <td><font size="2"><?= $kontrak->study->pendidikanTertinggi->HighestEduLevel; ?></td>                </tr>
                
                <tr>
                    <td><font size="2"><strong>Status Perakuan Ketua Jabatan</strong></td>
                    <td><font size="2"><?= $kontrak->status_jfpiu; ?></td>
                </tr>
                
                 <tr>
                    <td><font size="2"><strong>Tempoh Pengajian</strong></td>
                    <td><font size="2"><?= $kontrak->tempohpengajian; ?></td>
                </tr>
                
            </table>
</div>
  </div>
  </div>

<div class="x_panel">
    <div class="x_content">
                 <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2"><font size="2">No.</font></th>
                                    <th class="text-center" rowspan="2"><font size="2">Perkara</font></th>
                                    <th class="text-center" colspan="2"><font size="2">Tindakan</font></th>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center"><font size="2">Ya</font></th>
                                    <th class="column-title text-center"><font size="2">Tidak</font></th>
                                </tr>
                            </thead>
                            <?php
                            if ($kriteriakpi) 
                            { $no=0;?>
                                <?php foreach ($kriteriakpi as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblSemakSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno])->one();
                                ?>
                                <tr>
                                    <td class="text-center"><font size="2"><?php echo $no; ?></font></td>
                                    <td class="text-justify"><font size="2"><?php echo $kpi->syarat; ?></font></td>
                                    <td class="text-center"><?php if($mod->semak_latihan === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_latihan === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                            }
                            ?>
                        </table>
                    </div>        </div></div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">  
     <div class="x_panel">
          <div class="x_title">
                   
               <center><strong><font size="2">Hasil Semakan</strong></center>
                     
                    <div class="clearfix"></div>
                </div>
     
    <table class="table table-sm table-bordered">

                   <tr>
                    <td width="15%"><font size="2"><strong>Semakan</strong></td>
                    <td><font size="2"><?= $kontrak->status_semakan; ?></td>
                </tr>
                <tr>
                    <td><strong><font size="2">Catatan:</strong></td>
                    <td><font size="2"><?= $kontrak->ulasan_bsm ?></td>
                </tr>

                 
                
            </table>
</div>
  </div>
  </div>

<p align="right"><font size="2">   <?php echo "[Tarikh Dicetak:"  .' '.date("Y-m-d").', '.  date("h:i:sa")."]";?></p>
