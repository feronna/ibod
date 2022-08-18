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
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>



<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Kemaskini Senarai Tetapan</strong></h2>
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
                        <th class="column-title text-center">TARIKH MESYUARAT</th>
                        <th class="column-title text-center">TARIKH TUTUP MAKLUMBALAS</th>
                        <th class="column-title text-center">PERKARA</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">KEMASKINI</th>
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
                            <td><?= strtoupper(($senarai->tblRekod->bil_jpu))."&nbsp"."KALI KE-"."&nbsp".($senarai->tblRekod->kali_ke)?></td>
                            <td><?= $senarai->tblRekod->tarikhRekod ?></td>
                            <td><?= $senarai->tarikhTutup ?></td>
<!--                            <td>
                              $date1 =   date('Y-m-d', strtotime(date('Y-m-d')));
                              $date2 = date_format(date_create(date($senarai->tarikh_tutup)), 'Y-m-d');
                              $diff = date_diff($date1,$date2);
                              $tempohExpired = "$diff->d  hari, $diff->m  bulan, $diff->y tahun";
                            
                              echo $tempohExpired</td>-->
                            <td style="text-align:left"><?= $senarai->tblRekod->perkara ?></td>
                                <td><?php 
                                 $today = date('Y-m-d', strtotime(date('Y-m-d')));
                                 $end = date_format(date_create(date($senarai->tarikh_tutup)), 'Y-m-d');
                                if($today >= $end){
                                echo '<span class="label label-danger">EXPIRED</span>';
                            }else{
                                echo '<span class="label label-info">ACTIVE</span>';
                            }
                           ?></td>
                                                                            <td>
                            <?=
                             Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['kemaskini-tetapan', 'id' => $senarai->id, 'title' => 'kemaskini-tetapan'], ['class' => 'btn btn-default'])
                           .  Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-tetapan', 'id' => $senarai->id, 'title' => 'padam-tetapan'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) ;
                       ?>
    </td>
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


