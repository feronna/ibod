<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
use kartik\time\TimePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;

$statusLabel = [
        0 => 'STATUS BELUM SELESAI',
        1 => 'STATUS SELESAI'
   
];

?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>



<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Rekod Index Memorandum</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">BIL.JPU</th>
                        <th class="column-title text-center">KALI KE-</th>
                        <th class="column-title text-center">TARIKH MESYUARAT</th>
                        <th class="column-title text-center">TARIKH TUTUP MAKLUMBALAS</th>
                  
                        <th class="column-title text-center">STATUS INDEX</th>
                        <th class="column-title text-center">KEMASKINI URUTAN MINIT</th>
                        <th class="column-title text-center">CETAK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($senarai){
                    foreach ($senarai as $senarai) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= strtoupper(($senarai->bil_jpu)) ?></td>
                            <td><?= $senarai->kali_ke ?></td>
                            <td><?= $senarai->tarikhRekod ?></td>
                            <td><?= $senarai->tarikhTamat ?></td>
                            <td><?= $statusLabel[$senarai->status] ?></td>

                           <td><?= Html::a('<i class="fa fa-sort" aria-hidden="true"></i>', ['sorting', 'bil_jpu' => $senarai->bil_jpu], ['class' => 'btn btn-default'])?> </td>
                            <td><?= Html::a('<i class="fa fa-print" aria-hidden="true"></i>', ['jana-pelaporan', 'bil_jpu' => $senarai->bil_jpu, 'title' => 'Cetak'], ['class' => 'btn btn-default'])?> </td>
                        </tr>
                     <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>  
                            
                          
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


