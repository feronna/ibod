<?php
use yii\helpers\Url;
use yii\helpers\Html;

$statusLabel = [
        1 => '<span class="label label-warning">Dalam Tindakan KJ</span>',
        2 => '<span class="label label-primary">Dalam Tindakan JKTT</span>',
        4 => '<span class="label label-success">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>',
        null  => '<span class="label label-danger">Ditolak</span>'
];

$options =[
         1=> 'Permohonan Baharu',
         2=> 'Pertambahan Harta',
         4 => 'Tiada Perubahan',
         3=> 'Pelupusan Harta'
];
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>

<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Status Permohonan Isytihar Harta</strong><small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                  
                            <th class="column-title">TARIKH PERMOHONAN</th>
                            <th class="column-title">JENIS PERMOHONAN</th>
                            <th class="column-title">BORANG</th>
                            <th class="column-title">STATUS</th>
                            <th class="column-title">SALINAN SURAT</th>
                             <th class="column-title"></th>
                        </tr>
                        </thead>
                        <tbody>
                            
                        <?php  foreach ($semakan as $key => $semakans){ ?>
                            <tr> 
                                <td><?= $key+1 ?></td>
                             
                                <td><?= $semakans->tarikhDihantar?></td>
                                <td><?= $options[$semakans->jenis_permohonan]?></td>
                                <td><?=Html::a('<i class="fa fa-info-circle">', ["harta/borang", 'id' => $semakans->id]);
                     ?></td>
                                <td><?= $statusLabel[$semakans->status] ?></td>

                                <td>
                                    <?php if($semakans->letter_sent == 1){ ?>
                                        <?= \yii\helpers\Html::a('', ['harta/generate-letter', 'id' => $semakans->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                        <?php }
                               
                        }  ?>
                                    
                               
                              
                            </tr>
                   
                        </tbody>

                    </table>

                    <ul>
                        <li><span class="label label-warning">Dalam Tindakan KJ</span> : Borang Berjaya dihantar dan Menunggu Pengakuan dari Ketua Jabatan</li>
                        <li><span class="label label-primary">Dalam Tindakan JKTT</span> :Menunggu Kelulusan dari JKTT</li>
                        <li><span class="label label-success">Berjaya</span> : Perisyitiharan Harta Kakitangan Disahkan Oleh JKTT</li>
                        <li><span class="label label-danger">Ditolak</span> : Perisyitiharan Harta Kakitangan Tidak disahkan oleh JKTT</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

