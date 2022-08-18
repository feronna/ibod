<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\alert\Alert;

$this->title = $level;

?>


<?php
echo Alert::widget([
    'options' => [
        'class' => 'text-lg-left',
        'bg-'
    ],
    'body' => 'Sila lengkapkan subjek dan gred untuk setiap tahap pendidikan seperti yang tertera dalam STPM/SPM/PMR atau yang setaraf dengannya.',
]);
?>
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Tambah Mata Pelajaran', ['admintambah-subjek', 'Edu_id'=>$Edu_id,'icno'=>$icno], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Subjek</th>
                    <th>Gred</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($subjek) {
                    
                   foreach ($subjek as $subjekkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $subjekkakitangan->subjek; ?></td>
                    <td><?= $subjekkakitangan->gred; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminkemaskini-subjek', 'id' => $subjekkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['adminpadam-subjek', 'id' => $subjekkakitangan->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                <?php }
                 }
                   
                else{
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                   } 
                ?>
            </table>
            </div>
        </div>
    </div>




