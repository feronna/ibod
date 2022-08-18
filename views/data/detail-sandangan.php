<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
error_reporting(0);
$this->title = 'Status Sandangan';

?> 
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['data/admin-status-sandangan'], ['class' => 'btn btn-primary']) ?>
         <?= Html::button('Tambah', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-sandangan?icno='.$model->ICNO]),'class' => 'btn btn-primary mapBtn']) ?>

            <div class="table-responsive">
            <p style="color: green">
           ** Sila pastikan bulan pergerakan gaji (Perkara 11.PERGERAKAN GAJI) adalah tepat berdasarkan tarikh sandangan semasa.
            </p>
         
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Gred Jawatan</th>
                    <th>Status Sandangan </th>
                    <th>Jenis Lantikan</th>
                    <th>Tarikh Mula Sandangan</th>
                  
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($sandangan) {
                   foreach ($sandangan as $sandangan) {
                ?>
                <tr>
                    <td><?= $sandangan->gredJawatan->nama; ?>(<?= $sandangan->gredJawatan->gred; ?>)</td>
                    <td><?= $sandangan->statusSandangan->sandangan_name; ?></td>
                    <td><?= $sandangan->jenisLantikan->ApmtTypeNm; ?></td>
                    <td><?= $sandangan->tarikhMulaSandangan?></td>
                    <td class="text-center"><?= Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-sandangan', 'id' => $sandangan->id]),'style'=>'background-color: transparent; 
                          border: none;', 'class' => 'fa fa-edit mapBtn'])?>| <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-sandangan', 'id' => $sandangan->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
              ]) ?></td>  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



