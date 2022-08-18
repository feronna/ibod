<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$statusLabel = [
        1 => '<span class="label label-primary">Baru</span>',
        2 => '<span class="label label-info">Selesai Tindakan KP dan Menunggu Tindakan KJ</span>',
        3 => '<span class="label label-success">Selesai Tindakan KJ dan Menunggu Kelulusan</span>',
        4 => '<span class="label label-warning">Berjaya</span>',
        5 => '<span class="label label-danger">Ditolak</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
];


error_reporting(0);
?>

    <?php echo $this->render('/ptb/_menu'); ?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan PTB</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">Tarikh Permohonan</th>
                    <th class="text-center">Jenis Permohonan</th>
                    <th class="text-center">JFPIU Semasa </th>
                    <th class="text-center">JFPIU Cadangan </th>
                    <th class="text-center">JFPIU Baharu </th>
	            <th class="text-center">Status</th>
                    <th class="text-center">Salinan Surat</th>
	
                </tr>
                <?php foreach ($provider->getModels() as $key=>$item): ?>
                        <tr>
                          <td><?= $key+1 ?></td>
                          <td><?= $item->application->applicant->CONm ?></td>
                          <td><?= $item->application->created?></td>
                          <td><?= $item->application->type->name?></td>
                          <td><?= $item->application->oldDepartment->fullname?></td>
                           <td><?= $item->application->newDepartment->fullname?></td>
                          <td><?= $item->application->approvedDepartment->fullname?></td>
                
                          <td align='center'><?= $statusLabel[$item->application->status]?></td>
                           <td align= 'center'>
                                    <?php if(isset($item->application->letter)){ ?>
                                        <?= \yii\helpers\Html::a('', ['ptb/applicant-generate-letter', 'id' => $item->application->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                    <?php } ?>
                                   
                           </td>
                           
                          
                               
			  

                <?php endforeach;
?>
            </table>
        </div>
      
            
            <?= LinkPager::widget([
                'pagination' => $provider->pagination,
                
            ]) ?>
        </div>
    </div>
</div>

