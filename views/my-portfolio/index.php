<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;



$statusLabel = [
        1 => '<span class="label label-primary">DIPERAKUKAN</span>',
        2 => '<span class="label label-danger">DITOLAK</span>',
        null => '<span class="label label-danger">TIADA TINDAKAN</span>',
    
];
$statusLabel2 = [
        1 => '<span class="label label-primary">DILULUSKAN</span>',
        2 => '<span class="label label-danger">DITOLAK</span>',
        null => '<span class="label label-danger">TIADA TINDAKAN</span>',
    
];


?>

<div class="col-md-12">
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app','Maklumat Umum'), ['/my-portfolio/view-maklumat-umum','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Tujuan Pewujudan Jawatan'), ['/my-portfolio/tujuan-jawatan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Akauntabiliti'), ['/my-portfolio/lihat-akauntabiliti','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Dimensi'), ['/my-portfolio/lihat-dimensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kelayakan Akademik'), ['/my-portfolio/lihat-kelayakan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kompetensi'), ['/my-portfolio/lihat-kompetensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Pengalaman'), ['/my-portfolio/lihat-pengalaman','id' => $deskripsi->id], ['class' => 'btn btn-success']);

 if($display){
      echo '';
  }else{
  echo Html::a(Yii::t('app','Pengesahan'), ['/my-portfolio/pengesahan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Jana JD'), ['/my-portfolio/index','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  }

?>
         </div>
    </div>
</div>
</div>
<div class="x_panel"> 
        <div class="x_title">
            <h2>Jana JD</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $model->biodata->CONm?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?php
                            if ($model->biodata->NatCd == "MYS") {
                                echo strtoupper($model->biodata->ICNO);
                            } else {
                                echo $model->biodata->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?=strtoupper($model->jawatanss->nama); ?> GRED (<?= $model->jawatanss->gred; ?>)</td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                        <td><?= strtoupper($model->department->fullname); ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Dihantar</th>
                        <td><?php if($model->tarikh_hantar == null){
                           echo '<span class="label label-danger">BELUM DIHANTAR</span>';
                        }
                            else{
                            echo $model->tarikh_hantar;
                          }?>
                        </td>  
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Ketua Perkhidmatan</th>
              
                       <td>
                       <?php if($model->kp != null){
                           echo strtoupper($model->ketuaPerkhidmatan->CONm);
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Perakuan Ketua Perkhidmatan</th>
                        <td><?php if($model->kp != null){
                        echo $statusLabel[$model->kp_agree];
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Perakuan Ketua Perkhidmatan</th>
                      
                         <td>
                       <?php if($model->kp != null){
                         echo  strtoupper($model->perakuan_kp);
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td>
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Perakuan</th>
                
                           <td>
                       <?php if($model->kp != null){
                        echo   $model->tarikh_perakuan_kp;
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td>
                    </tr>
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Ketua Jabatan</th>
                        <td><?= strtoupper($model->ketuaJabatan->CONm) ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Kelulusan Ketua Jabatan</th>
                        <td><?= $statusLabel2[$model->kj_agree] ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Kelulusan Ketua Jabatan</th>
                        <td><?=strtoupper($model->perakuan_kj) ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Kelulusan</th>
                        <td><?= $model->tarikh_perakuan_kj ?></td> 
                    </tr> 
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">MYJD</th>
                        <td><?= Html::a('<span class="fa fa-info-circle" aria-hidden="true">  PAPAR DESKRIPSI</span>', ['my-portfolio/deskripsi-tugas', 'id' => $deskripsi->id], ['class' => 'btn btn-primary btn-block']) ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Cetak MYJD</th>
                        <td><?= Html::a('<span class="fa fa-info-circle" aria-hidden="true">  CETAK DESKRIPSI</span>', ['my-portfolio/generate-letter', 'id' => $deskripsi->id], ['class' => 'btn btn-success btn-block']) ?></td> 
                    </tr>
                </table>
            </div> 

        </div>
    </div>
