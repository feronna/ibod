<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\checkbox\CheckboxX;
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
 echo Html::a(Yii::t('app','PERAKUAN'), ['/portfolio/perakuan','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
 echo Html::a(Yii::t('app','JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  ?>
         </div></div>
<div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-info alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:black">
                          <h5 style="color:white">
                              <i class="fa fa-info-circle" style="color:white"></i> 
                               PASTIKAN SEMUA PERKARA DI TAB MENU MAKLUMAT KHUSUS DIISI (STATUS SELESAI) SEBELUM MENGHANTAR MYPORTFOLIO ANDA.</h5>
                          
                        
                         </table>
                </div>
            </div>

     <div class="x_panel">

        <div class="x_title">
            <h2>PERAKUAN</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Pegawai Peraku</th>
                        <td>
                       <?php if($model->kp != null){
                          echo  $model->ketuaPerkhidmatan->CONm;
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                     
                       <td>
                       <?php if($model->kp != null){
                        echo  strtoupper($model->ketuaPerkhidmatan->jawatan->nama); echo "\n"; echo 'GRED'; echo "\n"; echo '('; echo strtoupper($model->ketuaPerkhidmatan->jawatan->gred); echo ')';
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td>
                     </tr> 
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Pegawai Pelulus</th>
                        <td><?= strtoupper($model->ketuaJabatan->CONm) ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= strtoupper($model->ketuaJabatan->jawatan->nama)?> GRED (<?= strtoupper($model->ketuaJabatan->jawatan->gred)?>)</td> 
                    </tr> 
                   
                     
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Hantar</th>
                        <td><?php if($model->status_hantar_portfolio != null){
                            echo '<span class="label label-success">SELESAI DIHANTAR</span>'; 
                        }
                            else{
                            echo '<span class="label label-danger">BELUM DIHANTAR</span>'; 
                          }
                        
?></td> 
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Hantar</th>
                        <td><?php if($model->status_hantar_portfolio != null){
                            echo $model->tarikh_hantar_portfolio; 
                        }
                            else{
                            echo '<span class="label label-danger">BELUM DIHANTAR</span>'; 
                          }
                        
?></td> 
                    </tr>
                    
                </table>
             
               <div class="x_panel" style="display: <?php echo $displaymohon;?>">
               <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
               <?php
               
               echo $form->field($model, 'status_hantar_portfolio')->widget(CheckboxX::classname(), [
       
                       'autoLabel' => true,
                       'labelSettings' => [
                      'label' => '  <h style="color: green">
                * Pemohon hendaklah memastikan segala butiran didalam borang adalah betul sebelum dihantar
                </h>',
                        'position' => CheckboxX::LABEL_RIGHT
                          ]
                       ])->label(false);
               
               
               ?>
                 
                    <div class="ln_solid"></div>

            <div class="form-group">
                <div>
                 
                    <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['confirm'=>'Sila pastikan semua maklumat adalah tepat. Borang yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
              
                </div>
            </div>
              </div>
                

               <?php ActiveForm::end(); ?>


            </div>
            </div> 

        </div>
        
        <div class="x_panel">
   
        <div class="x_title">
            <strong><h2>JADUAL PENGEMASKINIAN</h2></strong>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        <div class="x_content">
            
          <div class="table-responsive">
              <p style="color:black">
                    ** Jadual Pengemaskinian Menyatakan Maklumat Terkini Perubahan Pada Sebarang TAB MyPortfolio.</p>
           
                <table class="table table-sm table-bordered">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">TARIKH TERKINI KEMASKINI</th>
                            <th class="column-title">PERKARA</th>
                            <th class="column-title">STATUS KEMASKINI </th>
                       
                            
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:center">1.</td>
                                <td style="text-align:center"><?= $carta->created_dt?></td>
                                <td style="text-align:left">Carta Organisasi</td>
                                <td style="text-align:center"><?php if ($carta){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">2.</td>
                                <td style="text-align:center"><?= $carta->created_dt?></td>
                                <td style="text-align:left">Carta Fungsi</td>
                                <td style="text-align:center"><?php if ($fungsi){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">3.</td>
                                <td style="text-align:center"><?= $aktiviti->created_at?></td>
                                <td style="text-align:left">Aktiviti-Aktiviti Bagi Fungsi</td>
                                <td style="text-align:center"><?php if ($aktiviti->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">4.</td>
                                <td style="text-align:center"><?= $deskripsi->created_at?></td>
                                <td style="text-align:left">Deskripsi Tugas</td>
                                <td style="text-align:center"><?php if ($deskripsi->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">5.</td>
                                <td style="text-align:center"><?= $proses->created_at?></td>
                                <td style="text-align:left">Proses Kerja</td>
                                <td style="text-align:center"><?php if ($proses){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             
                          
                             <tr>
                                <td style="text-align:center">6.</td>
                                <td style="text-align:center"><?= $undang->created_at?></td>
                                <td style="text-align:left">Senarai Undang - Undang, Peraturan Dan Punca Kuasa</td>
                                <td style="text-align:center"><?php if ($undang->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">7.</td>
                                <td style="text-align:center"><?= $borang->created_at?></td>
                                <td style="text-align:left">Senarai Borang</td>
                                <td style="text-align:center"><?php if ($borang->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                             <tr>
                                <td style="text-align:center">8.</td>
                                <td style="text-align:center"><?= $jawatanKuasa->created_at?></td>
                                <td style="text-align:left">Senarai Jawatankuasa Yang Dianggotai</td>
                                <td style="text-align:center"><?php if ($jawatanKuasa->created_at != null){
                               echo '<span class="label label-success">SELESAI</span>';
                                }else{
                               echo '<span class="label label-warning">BELUM DIISI</span>';
                                }
                                    ?></td>
                          
                            </tr>
                            
           

                    </table>
            
          
        </div>
        
    </div>
            </div>
    </div>
</div>
        
  
    




            
       
