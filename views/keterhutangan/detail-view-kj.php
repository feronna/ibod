<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>


<div class="row">
<div class="col-md-12 col-xs-12"> 
 <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Pegawai</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $model->kakitangan->CONm?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?php
                            if ($model->kakitangan->NatCd == "MYS") {
                                echo strtoupper($model->kakitangan->ICNO);
                            } else {
                                echo $model->kakitangan->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?=strtoupper($model->kakitangan->jawatan->nama); ?> (<?= $model->kakitangan->jawatan->gred; ?>)</td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                        <td><?= strtoupper($model->kakitangan->department->fullname); ?></td> 
                    </tr> 
                </table>
                
                
                 <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <td>BULAN/TAHUN</td>
                        <td>PENDAPATAN</td> 
                        <td>PEMOTONGAN</td> 
                        <td>JUMLAH BERSIH</td> 
                        <td>EMOLUMEN KURANG 40%</td> 
                    </tr>
                    <?php foreach($data as $payoll){ ?>
                    <tr>
                        <td><?= $payoll->MPH_PAY_MONTH ?></td>
                        <td>RM <?= $payoll->MPH_TOTAL_ALLOWANCE?></td> 
                        <td>RM <?= $payoll->MPH_TOTAL_DEDUCTION ?></td> 
                        <td>RM <?= ($payoll->MPH_TOTAL_ALLOWANCE)-($payoll->MPH_TOTAL_DEDUCTION) ?></td> 
                        <td><?= sprintf('%0.2f', round(( (($payoll->MPH_TOTAL_ALLOWANCE)-($payoll->MPH_TOTAL_DEDUCTION)) /$payoll->MPH_TOTAL_ALLOWANCE)*100, 2)) ?>%</td> 
                    </tr>
                    <?php  } ?>
               
                </table>
            </div> 

        </div>
    </div>
</div>
</div>



            
       
