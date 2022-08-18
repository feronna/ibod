<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$agree = [
    0 => 'Tidak Dipersetujui',
    1 => 'Setuju'

];

$statusLabel = [
    1 => '<span class="label label-primary">Baru</span>',
    2 => '<span class="label label-info">Selesai Persetujuan dan Menunggu Perakuan</span>',
    3 => '<span class="label label-success">Selesai Perakuan dan Menunggu Kelulusan</span>',
    4 => '<span class="label label-warning">Berjaya</span>',
    0 => '<span class="label label-danger">Ditolak</span>',
    5 => '<span class="label label-danger">Ditolak</span>',
    null => '<span class="label label-info">Belum ambil tindakan</span>',
];
$a = [
    0 => [
        'update' => 'Tiada Rekod',
    ]
];
?>

    <?php echo $this->render('/ptb/_menu'); ?>

<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Data Permohonan (Dalam Proses)</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <p class="text-success" style="margin-bottom: 20px">
                <b>*Hanya data yang belum diperaku/dipersetuju yang boleh dikemaskini.</b>
            </p>
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">Tarikh Permohonan</th>
                    <th class="text-center">Jenis Permohonan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Nama Pegawai Pensetuju</th>
                    <th class="text-center">Nama Pegawai Peraku</th>
                    <th class="text-center">Pegawai Pensetuju</th>
                    <th class="text-center">Pegawai Peraku</th>
                </tr>
            
                  <?php foreach ($provider->getModels() as $bil=>$item): ?>
                    <tr>
                        <td><?= $bil+1 ?></td>
                        <td><?= $item->applicant->CONm ?></td>
                        <td><?= $item->created?></td>
                        <td><?= $item->type->name?></td>
                        <td><?= $statusLabel[$item->status] ?></td>
                        <td><?= $item->pensetuju->staff->CONm?></td>
                         <td><?= $item->peraku->staff->CONm?></td>
                        <td>
                            <?php
                            if($item->pensetuju){

                                if(is_null($item->pensetuju->agree)){
                                    echo Html::a('Kemaskini Pensetuju', ['ptb/kemaskini-data-pensetuju', 'id' => $item->id], ['class'=>'btn btn-success btn-xs']);
                                }else{
                                    echo "<span class='badge badge-success'>Telah Dipersetuju</span>";
                                }
                            }else{
                                echo Html::a('Tambah Pensetuju', ['ptb/kemaskini-data-pensetuju', 'id' => $item->id], ['class'=>'btn btn-info btn-xs']);
                            }
                            ?>
                        </td>
                        
                          <td>
                            <?php
                                if($item->peraku){

                                    if(is_null($item->peraku->agree)){
                                        echo Html::a('Kemaskini Peraku', ['ptb/kemaskini-data-peraku', 'id' => $item->id], ['class'=>'btn btn-success btn-xs']);
                                    }else{
                                        echo "<span class='badge badge-success'>Telah Diperaku</span>";
                                    }
                                }else{
                                    echo Html::a('Tambah Peraku', ['ptb/kemaskini-data-peraku', 'id' => $item->id], ['class'=>'btn btn-info btn-xs']);
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