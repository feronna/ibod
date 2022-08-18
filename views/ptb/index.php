<?php
use yii\helpers\Url;
use yii\helpers\Html;

$statusLabel = [
        1 => '<span class="label label-warning">Dalam Tindakan KP</span>',
        2 => '<span class="label label-info">Dalam Tindakan KJ</span>',
        3 => '<span class="label label-primary">Dalam Tindakan BSM</span>',
        4 => '<span class="label label-success">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>'
];
?>


    <?php echo $this->render('/ptb/_menu');?>

<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Status Permohonan Pertukaran</strong><small>(PTB)</small></h2>
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
                            <th class="column-title">JFPIU SEMASA </th>
                            <th class="column-title">JFPIU YANG DICADANGKAN </th>
                             
                            <th class="column-title">JFPIU BARU </th>
                            <th class="column-title">STATUS</th>
                            <th class="column-title">SALINAN SURAT</th>
                            <th class="column-title">NOTA SERAH TUGAS</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php  if($display == ''){foreach ($applications as $key => $application){ ?>
                            <tr> 
                                <td><?= $key+1 ?></td>
                                
                                <td class="text-center"><?= $application->created?></td>
                                   <td class="text-center"><?= $application->type->name?></td>
                                <td class="text-center"><?= $application->oldDepartment->fullname?></td>
                                
                                <td align= 'center'><?= $application->newDepartment->fullname ?></td>
                                  
                                <td align= 'center'><?= ($application->approved_dept != null)? $application->approvedDepartment->fullname : '' ?></td>
                                <td><?= $statusLabel[$application->status] ?></td>

                                <td align= 'center'>
                                    <?php if($application->letter_sent == 1){ ?>
                                        <?= \yii\helpers\Html::a('', ['ptb/applicant-generate-letter', 'id' => $application->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                        <?php }
                               
                        
                                    
                                    
                                     ?>
                                   
                                </td>
                            <td align= 'center'>
                                    <?php if($application->letter_sent == 1 && $application->pelulus->agree == 1){ ?>
                                        <?= \yii\helpers\Html::a('', ['ptb/nota', 'id' => $application->id], ['class'=>'fa fa-edit', 'target' => '_blank']) ?>
                        <?php }
                               
                        
                                    }
                                    
                                    } ?>
                                   
                                </td>

                            </tr>
                   
                        </tbody>

                    </table>

                    <ul>
                        <li><span class="label label-warning">Dalam Tindakan KP</span> : Menunggu Persetujuan dari Ketua Pentadbiran</li>
                        <li><span class="label label-info">Dalam Tindakan KJ</span> :Menunggu Perakuan dari Ketua Jabatan</li>
                        <li><span class="label label-primary">Dalam Tindakan BSM</span> :Menunggu Kelulusan dari BSM</li>
                        <li><span class="label label-success">Berjaya</span> : Diluluskan</li>
                        <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

