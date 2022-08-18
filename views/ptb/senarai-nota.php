<?php

use yii\helpers\Html;
?>

        <?php echo $this->render('/ptb/_menu'); ?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Nota Serah Tugas</strong></h2>
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
                     <th class="text-center">Salinan Nota Serah Tugas</th>
                       <th class="text-center">Catatan Pemohon</th>
                        <th class="text-center">Nama Penerima</th>
                          <th class="text-center">Tarikh Tugas Diserahkan</th>
                        <th class="text-center">Tindakan</th>
                </tr>
                 <?php foreach ($belum_selesai as $bil=>$item): ?>
            
                        <tr>
                            <td><?= $bil+1 ?></td>
                            <td><?= $item->pemohon_name?></td>
                            <td align= 'center'>
                                     
                                       <?= \yii\helpers\Html::a('', ['ptb/tugas-generate-letter', 'id' => $item->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                       
                                   
                           </td>
                             <td><?= $item->catatan_individu?></td>
                           <td><?= nl2br($item->nama_pengganti)?></td>
                            
                          <td>
                        <?php  if ($item->update != null){
                   echo $item->updates;
                  }else{
                    echo 'Tugas belum diserahkan';
                 }
                            ?>
                            
                            
                         </td>
  
  
                                <td class="text-center"><?=  Html::a('<i class="fa fa-edit">', ["ptb/serah-tugas-bos", 'id' => $item->id] )?></td> 
                        </tr>
                        
                <?php endforeach; ?>
              
            </table>
        </div>
    </div>
</div>
</div>