<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Jawatan Terdahulu';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Jawatan', ['tambahjawatanterdahulu'], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama Jawatan</th>
                    <th>Deskripsi Jawatan</th>
                    <th>Tarikh Mula</th>
                    <th>Tarikh Akhir</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($jawatanterdahulu) {
                    
                   foreach ($jawatanterdahulu as $jawatanterdahulukakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $jawatanterdahulukakitangan->PrevPostNm; ?></td>
                    <td><?= $jawatanterdahulukakitangan->PrevPostDesc; ?></td>
                    <td><?= $jawatanterdahulukakitangan->prevPostStartDt; ?></td>
                    <td><?= $jawatanterdahulukakitangan->prevPostEndDt; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatjawatanterdahulu', 'id' => $jawatanterdahulukakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $jawatanterdahulukakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $jawatanterdahulukakitangan->id], [
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
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>



