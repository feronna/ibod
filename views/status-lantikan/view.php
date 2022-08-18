<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Status Lantikan';

?> 



<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['perkhidmatan/view', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah', ['tambah-lantikan', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
             <p style="color: green">
               * LANTIKAN TETAP DI UMS diisi sekali sahaja berdasarkan tarikh mula di lantik tetap walaupun berlaku PERUBAHAN SKIM/JAWATAN.
            </p>
             <p style="color: green">
               * LANTIKAN KONTRAK DI UMS diisi setiap kali kontrak disambung.
            </p>
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Status Lantikan</th>
                    <th>Tarikh Mula Lantikan </th>
                    <th>Tarikh Tamat Lantikan</th>
                  
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= $alamatkakitangan->statusLantikan->ApmtStatusNm; ?></td>
                    <td><?= $alamatkakitangan->tarikhMulaLantikan; ?></td>
                    <td> <?= $alamatkakitangan->tarikhTamatLantikan;  ?> </td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $alamatkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $alamatkakitangan->id], [
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



