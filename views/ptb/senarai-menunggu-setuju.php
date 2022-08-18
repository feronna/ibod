<?php

use yii\helpers\Html;

$agree = [
        0 => 'Tidak Dipersetujui',
        1 => 'Setuju'
   
];

$statusLabel = [
        1 => '<span class="label label-primary">Baru</span>',
        2 => '<span class="label label-info">Selesai Tindakan KP dan Menunggu Tindakan KJ</span>',
        3 => '<span class="label label-success">Selesai Tindakan KJ dan Menunggu Kelulusan</span>',
        4 => '<span class="label label-warning">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>',
      null => '<span class="label label-info">Belum ambil tindakan</span>',
];
$a = [
     0 => [
         'update' => 'Tiada Rekod',
        
        ]
     
    
 ];
?>


<div class="col-md-12">

        
        <?php echo $this->render('/ptb/_menu'); ?>
       
   
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan PTB</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <div class="hash" style="color: red">
             * Klik pada Butang Mohon Ulasan PPP sekiranya ingin mendapatkan ulasan PPP sebelum membuat Tindakan Persetujuan.
              </div><br>
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">Tarikh Permohonan</th>
                    <th class="text-center">Jenis Permohonan</th>
                    <th class="text-center">Status</th>
                     <th class="text-center">Ulasan PPP</th>
                    <th class="text-center">Tindakan</th>
                    
                     <th class="text-center">Tarikh Pensetujuan</th>
                     <th class="text-center">Status Pensetujuan</th>
                     <th class="text-center">Ulasan Pensetuju</th>
                </tr>
                <?php foreach ($setujuList as $bil=>$item): ?>
                        <tr>
                            <td><?= $bil+1 ?></td>
                            <td><?= $item->application->applicant->CONm ?></td>
                            <td align= 'center'><?= $item->application->created?></td>
                            <td align= 'center'><?= $item->application->type->name?></td>
                            <td align= 'center'><?= $statusLabel[$item->application->status] ?></td>
                            <td>
                            <?php
                            

                                if(($item->ppp->status_ppp == null && $item->ppp->ppp_icno == null) ){
                                    echo Html::a('Mohon Ulasan PPP', ['ptb/mohon-ulasan-ppp', 'id' => $item->id], ['class'=>'btn btn-danger btn-xs']);
                                    // echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mohon-ulasan-ppp', 'id' => $item->id]),'style'=>'background-color: transparent; 
                                           //  border: none;', 'class' => 'fa fa-edit mapBtn']);
                                    
                                    
                                } 
                                  if ($item->ppp->status_ppp == null && $item->ppp->ppp_icno != null){
                                    echo 'Menunggu Ulasan PPP';
                                    
                                }if(($item->ppp->status_ppp != null && $item->ppp->ppp_icno != null) ){
             
                                   echo Html::a('Lihat Ulasan', ['ptb/lihat-ulasan-ppp', 'id' => $item->id], ['class'=>'btn btn-success btn-xs ']);
                            }
                            // Html::a('Kemaskini Pensetuju', ['ptb/kemaskini-data-pensetuju', 'id' => $item->id], ['class'=>'btn btn-success btn-xs ']);
                            ?>
                                
                        </td>
                            
                            <td align= 'center'><?=Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan-pegawai', 'id' => $item->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn'])
                                 .'' .Html::a('<i class="fa fa-eye">', ['tindakan', 'id' => $item->id] )?></td>
                            <td>
                        <?php  if ($item->update != null){
                   echo  $item->updates;
                  }else{
                    echo 'Tiada Tindakan';
                 }
                ?>
                            
                            
               </td>
      
                          
                  <td>
                    <?php 
                   if ($item->agree == '1'){
                   echo  'Dipersetujui';
                  }if ($item->agree == '0'){
                    echo 'Tidak Dipersetujui';
                 }if ($item->agree == NULL){
                     echo 'Tiada Tindakan';
                 }
              
                 ?></td>
                             
                            <td><?= $item->notes?></td>
                           
                        </tr>
                        
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</div>