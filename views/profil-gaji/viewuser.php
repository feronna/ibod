<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\cuti\AksesPengguna;
use app\models\vhrms\ViewPayroll;
use kartik\export\ExportMenu;
use kartik\select2\Select2;


$this->title = 'Jumlah Gaji';
$statusLabel = [
        'ALLOWANCE' => 'PENDAPATAN',
         'DEDUCTION' => 'PEMOTONGAN',
        'EMPLOYER' => 'SUMBANGAN MAJIKAN',
];

?> 

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Jumlah Gaji</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= Html::a('Kembali', ['perkhidmatan/viewuser', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
      
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                     <th class="text-center">Tahun/Bulan</th>
                    <th class="text-center">No Rujukan</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Jumlah</th>
                    
                </tr>
                <?php foreach ($model as $key=>$item): ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= $item->MPH_PAY_MONTH?></td>
                            <td><?= $item->MPDH_INCOME_CODE?></td>
                             <td><?= $item->it_income_desc?></td>
                             <td><?= $statusLabel[$item->incomeType->it_trans_type]?></td>
                             <td><?= $item->MPDH_PAID_AMT?></td>
                         
                        </tr>
                <?php endforeach; ?>
          
                <?php foreach ($model2 as $key=>$item): ?>
                      
                            <td rowspan="3", colspan="4"></td>
                             <td><strong>JUMLAH PENDAPATAN</strong></td>
                             <td><?= $item->MPH_TOTAL_ALLOWANCE?></td>
                    
                             <tr><td><strong>JUMLAH PEMOTONGAN</strong></td>
                             <td><?= $item->MPH_TOTAL_DEDUCTION?></td></tr>
                  
                            
                             <tr><td><strong>GAJI BERSIH</strong></td>
                                 <td><?= $item->gajiBersih?></td></tr>
                        </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</div>


