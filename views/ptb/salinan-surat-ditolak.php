<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
$statusLabel = [
     
        1 => '<span class="label label-primary">Selesai Lapor Diri</span>',
        null => '<span class="label label-danger">Belum Lapor Diri</span>',
        0 => '<span class="label label-danger">Permohonan Ditolak</span>'
];
$statusLabel2 = [
     1 => '<span class="label label-primary">Dalam Tindakan KP</span>',
        2 => '<span class="label label-info">Dalam Tindakan KJ</span>',
        3 => '<span class="label label-success">Dalam Tindakan BSM</span>',
        4 => '<span class="label label-warning">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
     5 => '<span class="label label-danger">Ditolak</span>'
];

?>

        <?php echo $this->render('/ptb/_menu'); ?>

<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
                <div class="x_title">
            <h2><strong>Salinan Surat Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">No Kad Pengenalan</th>
                    <th class="text-center">JFPIU Lama</th>
                    <th class="text-center">JFPIU Yang Dimohon</th>
                      <th class="text-center">JFPIU Yang Diluluskan</th>
                    <th class="text-center">Status Permohonan</th>
                      <th class="text-center">Status Lapor Diri</th>
                       
                           <th class="text-center">Salinan Surat</th>
                    
                </tr>
                 <?php if ($display == '') { foreach ($lapors as $bil=>$item): ?>
            
                   
                        <tr>
                            <td><?= $bil+1 ?></td>
                            <td><?= $item->name?></td>
                            <td><?= $item->icno?></td>
                            <td><?= $item->oldDepartment->fullname?></td>
                            <td><?= $item->newDepartment->fullname?></td>
                           <td><?= $item->approvedDepartment->fullname?></td>
                                <td><?= $statusLabel2[$item->status] ?></td>
                              
                                 <td>
                        <?php  if ($item->status == 4){
                   echo   $statusLabel[$item->lapor];
                  }else{
                    echo 'Permohonan Ditolak';
                 }
                ?>
                            
                            
                            </td>
                      
                           
                            <td>
                                    <?php if(isset($item->letter)){ ?>
                                        <?= \yii\helpers\Html::a('', ['ptb/applicant-generate-letter', 'id' => $item->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                    <?php } ?>
                                 
                                </td>
                                 
                                 
                        </tr>
                        
                 <?php endforeach; }?>
              
            </table>
        </div>
    </div>
</div>
</div>
