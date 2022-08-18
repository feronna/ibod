<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Pengalaman Kerja';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Pengalaman', ['tambahpengalamankerja'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama Majikan</th>
                    <th>Sektor</th>
                    <th>Jenis Majikan(Jawatan)</th>
                    <th>Keterangan Tugas</th>
                    <th>Tarikh Mula</th>
                    <th>Tarikh Berhenti</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($pengalamankerja) {
                    
                   foreach ($pengalamankerja as $pengalamankerjakakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $pengalamankerjakakitangan->OrgNm; ?></td>
                    <td><?= $pengalamankerjakakitangan->sekpekerjaan ?></td>
                    <td><?= $pengalamankerjakakitangan->jenmajikan ?></td>
                    <td><?= $pengalamankerjakakitangan->PrevEmpRemarks; ?></td>
                    <td><?= $pengalamankerjakakitangan->prevEmpStartDt; ?></td>
                    <td><?= $pengalamankerjakakitangan->prevEmpEndDt; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpengalamankerja', 'id' => $pengalamankerjakakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $pengalamankerjakakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $pengalamankerjakakitangan->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin Membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



