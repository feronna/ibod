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


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-info">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-success">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-info">MAKLUMAT JD</span>'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
     <div class="x_panel">
         <div class="x_content"> 
   
<?php
  echo Html::a(Yii::t('app','CARTA ORGANISASI'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','CARTA FUNGSI'), ['/portfolio/carta-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','AKTIVITI FUNGSI'), ['/portfolio/aktiviti-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);

  echo Html::a(Yii::t('app','PROSES KERJA'), ['/portfolio/proses-kerja','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI UNDANG-UNDANG'), ['/portfolio/senarai-undang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  
 echo Html::a(Yii::t('app','SENARAI BORANG'), ['/portfolio/senarai-borang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','SENARAI JAWATANKUASA'), ['/portfolio/senarai-jawatankuasa','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','PERAKUAN'), ['/portfolio/perakuan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  ?>
         </div></div>


     <div class="x_panel">
        <div class="x_title">
            <h2>JANA MYPORTFOLIO</h2> <div class="clearfix"></div>
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
                        <td><?php if($model->tarikh_hantar_portfolio == null){
                           echo '<span class="label label-danger">BELUM DIHANTAR</span>';
                        }
                            else{
                            echo $model->tarikh_hantar_portfolio;
                          }?>
                        </td>  
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Pegawai Penilai Pertama</th>
              
                       <td>
                     <?= strtoupper($model->kakitangan->CONm) ?></td> 
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
                        <th class="col-md-3 col-sm-3 col-xs-12">Papar myPortfolio</th>
                        <td><?= Html::a('<span class="fa fa-info-circle" aria-hidden="true">  PAPAR </span>', ['portfolio/lihat-portfolio', 'id' => $model->id], ['class' => 'btn btn-info btn-block']) ?></td> 
                    </tr>
                   
                   
                </table>
            </div> 

        </div>
    </div>

         </div>
    </div>
