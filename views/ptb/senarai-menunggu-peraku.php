<?php

use yii\helpers\Html;

$statusLabel = [
        1 => '<span class="label label-primary">Baru</span>',
        2 => '<span class="label label-info">Selesai Tindakan KP dan Menunggu Tindakan KJ</span>',
        3 => '<span class="label label-success">Selesai Tindakan KJ dan Menunggu Kelulusan</span>',
        4 => '<span class="label label-warning">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>'
];


?>

        <?php echo $this->render('/ptb/_menu'); ?>
  
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan PTB</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">Tarikh Permohonan</th>
                    <th class="text-center">Jenis Permohonan</th>
		    <th class="text-center">Status</th>
                    <th class="text-center">Tindakan</th>
		
                     <th class="text-center">Tarikh Perakuan</th>
                    <th class="text-center">Status Perakuan</th>
                     <th class="text-center">Ulasan Perakuan</th>
                </tr>
                <?php foreach ($perakuList as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $item->application->applicant->CONm ?></td>
                           <td align= 'center'><?= $item->application->created?></td>
                            <td align= 'center'><?= $item->application->type->name?></td>
                            <td align= 'center'><?= $statusLabel[$item->application->status]?></td>
			    <td align= 'center' ><?=Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan-pegawai', 'id' => $item->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn'])
                            .' '.Html::a('<i class="fa fa-eye">', ["ptb/tindakan", 'id' => $item->id] )?></td>
                              <td align= 'center'>
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
                  }else if ($item->agree == '0'){
                    echo 'Tidak Dipersetujui';
                 }else if ($item->agree == NULL){
                     echo 'Tiada Tindakan';
                 }
              
                 ?>
                  
                  </td>
                 
                            <td>
                             <?php
                            if ($item->application->type_id = 1){
                               echo  $item->notes;
                            }if ($item->application->type_id = 2){
                                echo  $item->application->justification->fullname;
                            }
                            
                            
                           ?></td>
                                
                        </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</div>
