<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


$statusLabel = [
        1 => '<span class="label label-warning">Menunggu Perakuan Ketua Jabatan</span>',
        2 => '<span class="label label-primary">Selesai Perakuan dan Menunggu Kelulusan JKTT</span>',
        4 => '<span class="label label-success">Berjaya</span>',
       3 => '<span class="label label-success">Berjaya</span>',
        0 => '<span class="label label-danger">Ditolak</span>',
        5 => '<span class="label label-danger">Ditolak</span>',
      
];

$options =[
        1=> 'Permohonan Baharu',
        2=> 'Pertambahan Harta',
        3=> 'Pelupusan Harta',
        4=> 'Tiada Perubahan'
];

?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Isytihar Harta</strong></h2>
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
                    <th class="text-center">Jenis Permohonan</th>
                    <th class="text-center">Tarikh Isytihar</th>
	            <th class="text-center">Status</th>
                    <th class="text-center">Tarikh Perakuan</th>
                    <th class="text-center">Tindakan</th>
	
                </tr>
                <?php foreach ($provider->getModels() as $key=>$item): ?>
                        <tr>
                          <td><?= $key+1 ?></td>
                          <td align="center"><?= $item->AssetOwnerNm?></td>
                          <td align="center"><?=$options[$item->jenis_permohonan]?></td>
                          <td align="center"><?= $item->tarikhDihantar?></td>
                          <td align='center'><?= $statusLabel[$item->status]?></td>
                         <td align= 'center'>
                        <?php  if ($item->tarikh_perakuan!= null){
                   echo  $item->tarikhPerakuan;
                  }else{
                    echo 'Belum Diperakukan';
                 }
                ?>
                            </td>
                                <td align= 'center' ><?=Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['perakuan', 'id' => $item->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn'])
                            .' '.Html::a('<i class="fa fa-eye">', ["harta/borang", 'id' => $item->id] )?></td>
                           
                          
                               
			  

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

