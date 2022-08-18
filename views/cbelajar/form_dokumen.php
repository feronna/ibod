<?php

use yii\helpers\Html;
use yii\helpers\Url;

$title = $this->title = 'Muat Naik Dokumen';

?>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN BAHARU PENGAJIAN LANJUTAN SEPENUH MASA
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=> $iklan->id]) ?>
  <div class="x_panel">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
        <div class="x_title">
            <h2><strong><i class="fa fa-file"></i> Senarai Dokumen Yang Telah Dimuatnaik</strong></h2>
            <p align="right">
                <?php echo Html::a('Muatnaik Dokumen', ['cbelajar/senarai-dokumen', 'id'=>$iklan->id], ['class' => 'btn btn-success btn-sm']); ?>
                
                </p>
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
            <h4><strong>DOKUMEN BAGI PERMOHONAN KPT</strong></h4>
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Dokumen</th>
<!--                    <th class="text-center">Lampiran</th>-->
                    <th class="text-center">Tindakan</th>    
                </tr>
                </thead>
               <?php
                    if ($dokumen) {
                        $counter = 0;
                        foreach ($dokumen as $dokumen) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen->nama_dokumen))&& (!empty($dokumen->namafile))){?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen->namafile, true);?>"/>-->
                                <?php } else{
                                    
                                    echo '<strong style="color:red">Tiada Bukti Dilampirkan, Sila Padam & Muat Naik Semula</strong>';
                                }
?></u>
                      
                                            
                                         
                                      </td>
                                
                                <td class="text-center"  style="width:5%;">
                                  

<!--                              <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> |-->
                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['cbelajar/delete-dokumen-kpm?id='.$dokumen->id.'&i='.$dokumen->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
            </div>
         </div>
        
        <div class="x_content">
            <h4><strong>DOKUMEN  SOKONGAN BAGI PENGAJIAN LANJUTAN</strong></h4>
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Dokumen</th>
                    <th class="text-center">Tindakan</th>    
                </tr>
                </thead>
               <?php
                    if ($dokumen2) {
                        $counter = 0;
                        foreach ($dokumen2 as $dokumen2) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"  style="width:5%;"><?= $counter; ?></td> 
                                
                                <td><?php if((!empty($dokumen2->nama_dokumen))&& (!empty($dokumen2->namafile))){?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen2->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen2->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen2->namafile, true);?>"/>-->
                                <?php }
                                                     else{
                                    
                                    echo '<strong style="color:red">Tiada Bukti Dilampirkan, Sila Padam & Muat Naik Semula </strong>';
                                }                           
                                                                            ?></u>
                                         
                                      </td>
                                
                                <td class="text-center"  style="width:5%;">
                                  
                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>',['cbelajar/delete-dokumen?id='.$dokumen2->id.'&i='.$dokumen2->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
                
            </div>
            
             <div class="x_content">
            <h4><strong>DOKUMEN BAGI PERMOHONAN LUAR NEGARA</strong></h4>
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Dokumen</th>
<!--                    <th class="text-center">Lampiran</th>-->
                    <th class="text-center">Tindakan</th>    
                </tr>
                </thead>
               <?php
                    if ($dokumen3) {
                        $counter = 0;
                        foreach ($dokumen3 as $dokumen3) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"  style="width:5%;"><?= $counter; ?></td> 
                                
                                <td ><?php if((!empty($dokumen3->nama_dokumen))&& (!empty($dokumen3->namafile))){?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen3->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen3->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen3->namafile, true);?>"/>-->
                                <?php }
                                else{
                                 
                                    
                                    echo '<strong style="color:red">Tiada Bukti Dilampirkan, Sila Padam & Muat Naik Semula</strong>';
                              
                                }
?></u>
                      
                                            
                                         
                                      </td>
                                
                                <td class="text-center"  style="width:5%;">
                                  

<!--                              <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>',['uploads/', 'namafile' => $dokumen3->namafile] , ['class' => 'btn btn-default', 'target'=>"_blank"]) ?> |-->
                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['cbelajar/delete-dokumen-ln?id='.$dokumen3->id.'&i='.$dokumen3->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
                <p align ="right">
                 <?= Html::a('Seterusnya', ['cutibelajar/pengakuan-pemohon', 'id'=> $iklan->id], ['class' => 'btn btn-info btn-sm']); ?>
                 <?= Html::a('Kembali', ['cutibelajar/halaman-utama-pemohon'], ['class' => 'btn btn-primary btn-sm']) ?>
         </p> 
            </div>
   </div>
     </div>  </div> 
</div>

