<?php

use yii\helpers\Html;
use yii\helpers\Url;

$title = $this->title = 'Muatnaik Dokumen';

?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
<div class="x_content">  
 <span class="required" style="color:#062f49;">
<center> <h2><strong><?= strtoupper('
CUTI SABATIKAL /LATIHAN INDUSTRI '); ?>
                        </strong></h2> </center>
            </span> 
</div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=> $iklan->id]) ?>
<br/>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-file"></i> Senarai Dokumen Yang Telah Dimuatnaik</strong></h2>
            <p align="right">
                <?php echo Html::a('Muatnaik Dokumen', ['senarai-dokumen', 'id'=>$iklan->id], ['class' => 'btn btn-success btn-sm']); ?>
                
                </p>
            <div class="clearfix"></div>
        </div>
         
        
        <div class="x_content">
            <h4><strong>DOKUMEN BAGI CUTI SABATIKAL / LATIHAN INDUSTRI</strong></h4>
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
                                
                                <td><?php if((!empty($dokumen2->nama_dokumen))&& (!empty($dokumen2->namafile))):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen2->namafile), true); ?>" target="_blank"/> <u><?php echo $dokumen2->nama_dokumen ?>
<!--                                            <img src="<?= Url::to('@web/uploads'.$dokumen2->namafile, true);?>"/>-->
                                            <?php endif;?></u>
                                         
                                      </td>
                                
                                <td class="text-center"  style="width:5%;">
                                  
                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>',['delete-dokumen?id='.$dokumen2->id.'&i='.$dokumen2->iklan_id], ['class' => 'btn btn-default',
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
            
             
                </table>
                <p align ="right">
                 <?= Html::a('Seterusnya', ['cutibelajar/pengakuan-pemohon', 'id'=> $iklan->id], ['class' => 'btn btn-info btn-sm']); ?>
                 <?= Html::a('Kembali', ['cutibelajar/halaman-utama-pemohon'], ['class' => 'btn btn-primary btn-sm']) ?>
         </p> 
            </div>
   </div>
     </div> 



