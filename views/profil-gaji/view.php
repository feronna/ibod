<?php

use yii\helpers\Html;

$this->title = 'Jumlah Gaji';
$statusLabel = [
        '1' => 'Monthly',
        '2' => 'Part-time/Claims-based Salary',
        '3' => 'Bonus/Cash Assist (Separate)',
        '4' => 'BOD'
];

?> 

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Profil Gaji</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
  
            
       <?= Html::a( 'Kembali', Yii::$app->request->referrer,['class' => 'btn btn-primary']) ?>
       <?= Html::a('Tambah', ['tambah-profil-gaji', 'umsper' => $models->COOldID], ['class' => 'btn btn-success']);?>   
     
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                     <th class="text-center">Tarikh Mula</th>
                    <th class="text-center">Tarikh Akhir</th>
                    <th class="text-center">Status Gaji</th>
                    <th class="text-center">Jenis Gaji</th>
                    <th class="text-center">KWSP</th>
                    <th class="text-center">Jenis KWSP</th>
                    <th class="text-center">PERKESO</th>
                    <th class="text-center">Jenis PERKESO</th>
                    <th class="text-center">Cukai</th>
                    <th class="text-center">Pencen</th>
                    <th class="text-center">Kadar Harian/Jam</th>
                    <th class="text-center">Tindakan</th>
                </tr>
                
                     <?php foreach ($model as $key=>$item): ?>
                        <tr>
                             <td><?= $key+1 ?></td>
                             <td><?= $item->tarikhMula?></td>
                             <td><?php if($item->SS_END_DATE == '0000-00-00 00:00:00' ){
                                 echo '';
                             }else{
                               echo  $item->tarikhTamat;
                             }?></td>
                             <td class="center"><?= $item->statusGaji?></td>
                             <td><?= $statusLabel[$item->SS_SALARY_TYPE]?></td>
                             <td><?= $item->Kwsp?></td>
                             <td><?= $item->jenisKwsp->ET_DESC?></td>
                             <td><?= $item->Perkeso?></td>
                             <td><?= $item->jenisPerkeso->ST_DESC?></td>
                             <td><?= $item->Cukai?></td>
                             <td><?= $item->Pencen?></td>
                             <td><?= $item->SS_RATE?></td>
                             <td class="text-center"> <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-gaji', 'id' => $item->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-profil-gaji', 'id' => $item->id]) ?></td>  
               
                          
                         
                        </tr>
                <?php endforeach; ?>
              
            </table>
        </div>
    </div>
</div>
</div>


