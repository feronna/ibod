<?php

use yii\helpers\Html;


$this->title = 'Jumlah Gaji';
$statusLabel = [
        '1' => 'Monthly',
        '2' => 'Part-time/Claims-based Salary',
        '3' => 'Bonus/Cash Assist (Separate)',
        '4' => 'BOD'
];
error_reporting(0);
?> 

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/hrpayroll/_menu'); ?>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-money"></i> Maklumat Profil Gaji</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
         <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>  
       
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
                
                 <?php if($model) {
                   foreach ($model as $key=>$item) {
                ?>
     
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
                             <td class="text-center"> <?= Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['/profil-gaji/lihat-gaji', 'id' => $item->id]),'style'=>'background-color: transparent; 
                          border: none;', 'class' => 'fa fa-eye mapBtn'])?> </td>  
                        </tr>
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="13" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
              
            </table>
        </div>
    </div>
</div>
    </div>
</div>



