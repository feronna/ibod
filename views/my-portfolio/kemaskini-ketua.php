<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;



$a = [
    0 => [
        'update' => 'Tiada Rekod',
    ]
];
?>


<div class="col-md-12">
    <?php echo $this->render('/my-portfolio/_menu'); ?>
</div>

<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Ketua Perkhidmatan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <p class="text-success" style="margin-bottom: 20px">
      
            </p>
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pegawai</th>
                    <th class="text-center">JFPIU</th>
                    <th class="text-center">Tarikh Dokumen</th>
                    <th class="text-center">Nama Ketua Perkhidmatan</th>
                    <th class="text-center">Nama Ketua Jabatan</th>
                    <th class="text-center">Ketua Perkhidmatan</th>
                    <th class="text-center">Ketua Jabatan</th>
                </tr>
            
                  <?php foreach ($provider->getModels() as $bil=>$item): ?>
                    <tr>
                        <td><?= $bil+1 ?></td>
                        <td><?= $item->applicant->CONm ?></td>
                        <td><?= $item->applicant->department->fullname?></td>
                        <td><?= $item->tarikhDokumen?></td>
                        <td class="text-center"><?= $item->ketuaPerkhidmatan->CONm?></td>
                        <td class="text-center"><?= $item->ketuaJabatan->CONm?></td>
                       <td>
                            <?php
                          

                                if(is_null($item->kp)){
                                    echo Html::a('Tambah KP', ['my-portfolio/kemaskini-data-pensetuju', 'id' => $item->id], ['class'=>'btn btn-info btn-xs']);
                                }
                            else{
                                echo Html::a('Kemaskini KP', ['my-portfolio/kemaskini-data-pensetuju', 'id' => $item->id], ['class'=>'btn btn-success btn-xs']);
                            }
                            ?>
                        </td>
                        
                          <td>
                            <?php
                                if($item->ketuaJabatan){

                                    if(is_null($item->perakuan_kj)){
                                        echo Html::a('Kemaskini KJ', ['my-portfolio/kemaskini-data-peraku', 'id' => $item->id], ['class'=>'btn btn-success btn-xs']);
                                    }else{
                                        echo "<span class='badge badge-success'>Telah Diperakukan</span>";
                                    }
                                }else{
                                    echo Html::a('Tambah KJ', ['my-portfolio/kemaskini-data-peraku', 'id' => $item->id], ['class'=>'btn btn-info btn-xs']);
                                }
                            ?>
                        </td>
                
                    </tr>
                <?php endforeach; ?>
                  
            </table>
        </div>
                 <?= LinkPager::widget([
                'pagination' => $provider->pagination,
                
            ]) ?>
            
    </div>
</div>
</div>