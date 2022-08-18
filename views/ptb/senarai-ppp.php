<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


error_reporting(0);
?>


<div class="col-md-12">
    <?php echo $this->render('/ptb/_menu'); ?>
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Memohon Ulasan PPP</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="hash" style="color: green">
             * Mohon pihak tuan/puan untuk memberi ulasan berkenaan permohonan Pertukaran Tempat Bertugas kakitangan berikut.
              </div><br>
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">No Kad Pengenalan</th>
                    <th class="text-center">Jawatan dan Gred</th>
                    <th class="text-center">JFPIU Semasa </th>
                    <th class="text-center">Tindakan </th>
                    <th class="text-center">Lihat</th>
               
                  
	
                </tr>
                <?php foreach ($provider->getModels() as $key=>$item): ?>
                        <tr>
                          <td><?= $key+1 ?></td>
                          <td><?= $item->applicant->CONm ?></td>
                          <td><?= $item->applicant->ICNO?></td>
                          <td><?= $item->applicant->jawatan->nama?> (<?= $item->applicant->jawatan->gred?>)</td>
                          <td><?= $item->oldDepartment->fullname?></td>
                         <td align="center">
                            <?php
                            

                                if($item->status_ppp == null){
                                   // echo Html::a('Mohon Ulasan PPP', ['ptb/mohon-ulasan-ppp', 'id' => $item->id], ['class'=>'btn btn-info btn-xs']);
                                     echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['buat-ulasan-ppp', 'id' => $item->id]),'style'=>'background-color: transparent; 
                                             border: none;',  'class' => 'fa fa-edit mapBtn']);
                            
                                    
                                    
                                } 
                                  else{
                                    echo 'Ulasan Telah Dihantar';
                                    
                               }
                            
                            ?>
                                
                        </td>
                           <td align= 'center'><?=Html::a('<i class="fa fa-eye">', ['tindakan', 'id' => $item->pensetuju->id] )?></td>
                            
                   
                     
                <?php endforeach;
?>
            </table>
        </div>
      
            
            <?= LinkPager::widget([
                'pagination' => $provider->pagination,
                
            ]) ?>
        </div>
    </div>
</div>

