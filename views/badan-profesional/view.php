<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Keahlian (Kelab/Persatuan/Institusi/Kesatuan)';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Keahlian', ['tambahbadanprofesional'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama </th>
                    <th>Peringkat</th>
                    <th>No. Keahlian</th>
                    <th>Tarikh Mula Menyertai</th>
                    <th>Tarikh Tamat Menyertai</th>
                    <th>Yuran Dikenakan</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($badanprofesional) {
                    
                   foreach ($badanprofesional as $badanprofesionalkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $badanprofesionalkakitangan->nambadanprofesional ?></td>
                    <td><?= $badanprofesionalkakitangan->peringkat ? $badanprofesionalkakitangan->peringkat->LvlNm : '<span style="background-color:yellow;color:black;">Sila kemaskini peringkat Kelab/Persatuan/Institusi/Kesatuan ini.</span>' ?></td>
                    <td><?= $badanprofesionalkakitangan->membershipNo ?></td>
                    <td><?= $badanprofesionalkakitangan->tarikhmula ?></td>
                    <td><?= $badanprofesionalkakitangan->tarikhakhir; ?></td>
                    <td><?= $badanprofesionalkakitangan->staaktif ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatbadanprofesional', 'id' => $badanprofesionalkakitangan->profId]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $badanprofesionalkakitangan->profId]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $badanprofesionalkakitangan->profId], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                   <?php } 
                   
                }else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>
