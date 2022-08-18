<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
error_reporting(0);
$this->title = 'Status Jawatan';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['perkhidmatan/view', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah', ['tambah-sandangan', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
              <p style="color: green">
               * Sila pastikan bulan pergerakan gaji (Perkara 11.PERGERAKAN GAJI) adalah tepat berdasarkan tarikh sandangan semasa
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
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td>
                    
                    <?= $alamatkakitangan->gredJawatan->nama; ?>
                    (<?= $alamatkakitangan->gredJawatan->gred; ?>)
                    </td>
                    <td><?= $alamatkakitangan->statusSandangan->sandangan_name; ?></td>
                    <td><?= $alamatkakitangan->jenisLantikan->ApmtTypeNm; ?></td>
                    <td><?= $alamatkakitangan->tarikhMulaSandangan?></td>
                    <td class="text-center"> <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $alamatkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $alamatkakitangan->id], [
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



