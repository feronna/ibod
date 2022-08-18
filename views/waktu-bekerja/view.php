<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Asas Waktu Kerja';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['perkhidmatan/view', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
      
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Jenis WP</th>
                    <th>Keterangan</th>
                    <th>Tarikh Mohon</th>
                    <th>Tarikh Masuk</th>
                    <th>Tarikh Tamat</th>
               
                </tr>
                </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= $alamatkakitangan->wp->jenis_wp?></td>
                     <td><?= $alamatkakitangan->wp->detail?></td>
                    <td><?= $alamatkakitangan->tarikhMohons?></td>
                    <td><?= $alamatkakitangan->tarikhMulas?></td>
                      <td align="center">
                        <?php  if ($alamatkakitangan->end_date != null){
                   echo $alamatkakitangan->tarikhTamats;
                  }else{
                    echo '-';
                 }
                            ?>
                            
                            
                         </td>
                    
                    
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


