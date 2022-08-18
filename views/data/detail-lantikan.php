<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */
error_reporting(0);
$this->title = 'Status Lantikan';

?> 
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['data/admin-status-lantikan'], ['class' => 'btn btn-primary']) ?>
         <?= Html::button('Tambah', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-lantikan?icno='.$model->ICNO]),'class' => 'btn btn-primary mapBtn']) ?>

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
                <?php if($lantikan) {
                   foreach ($lantikan as $lantikan) {
                ?>
                <tr>
                    <td><?= $lantikan->statusLantikan->ApmtStatusNm; ?></td>
                    <td><?= $lantikan->tarikhMulaLantikan; ?></td>
                    <td>
                  <?php  if (($lantikan->statusLantikan->ApmtStatusCd == 1) && ($lantikan->retire->RetireAgeCd != null)){
                     echo  $lantikan->retire->tarikhKuatkuasa;  
                  }else{
                      echo $lantikan->tarikhTamatLantikan; 
                 }
                ?>
                </td>
                    <td class="text-center"><?= Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kemaskini-lantikan', 'id' => $lantikan->id]),'style'=>'background-color: transparent; 
                          border: none;', 'class' => 'fa fa-edit mapBtn'])?>| <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-lantikan', 'id' => $lantikan->id], [
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



