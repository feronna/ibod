<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
error_reporting(0);

$this->title = 'Keluarga';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/adminview', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::button('Tambah Keluarga', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['adminums-nonums','icno'=>$ICNO]),'class' => 'btn btn-primary mapBtn ']) ?> 
         <?= Html::a('<i class="fa fa-download" aria-hidden="true"> Muat Turun</i>', ['family-list','icno'=>$ICNO], ['class' => 'btn btn-success', 'target' => '_blank']) ?>  
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>No. Kad Pengenalan</th>
                    <th>Nama</th>
                    <th>Hubungan</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($keluarga) {
                    
                   foreach ($keluarga as $keluargakakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $keluargakakitangan->FamilyId; ?></td>
                    <td><?= $keluargakakitangan->FmyNm; ?></td>
                    <td><?= $keluargakakitangan->hubkeluarga; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihatkeluarga', 'id' => $keluargakakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdate', 'id' => $keluargakakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['admindelete', 'id' => $keluargakakitangan->id], [
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
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



