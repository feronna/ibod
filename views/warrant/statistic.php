<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\keselamatan\TblWarnaKad;
use yii\bootstrap\ActiveForm;
use app\models\kehadiran\TblYears;
use app\models\warrant\TblJawatan;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Warrant Lists</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th rowspan = "2" colspan = '1' class="text-center">Bil</th>
                            <th rowspan = "2" colspan = '1' class="text-center">Kategori</th>
                            <th rowspan = "2" colspan = '1' class="text-center">Waran</th>
                            <th colspan = '4' class="text-center">Pengisian</th>
                            <th rowspan = "2" colspan = '1' class="text-center">Kontrak Pusat</th>
                            <th rowspan = "2" colspan = '1' class="text-center">Jumlah Pusat</th>
                            <th rowspan = "2" colspan = '1' class="text-center">Jumlah Penyandang</th>
                           
                        </tr>
                        <tr>
                         
                            <th class="text-center">Tetap</th>
                            <th class="text-center">Kontrak</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Kosong</th>
                          
                        </tr>
                        
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:auto"><?php echo $bil++ ?></td>
                                    <td class="text-center" style="text-align:auto"><?php echo $senarai->category ?></td>
                                    <td class="text-center" style="text-align:auto"><?= TblJawatan::WarrantTotal($senarai->kategori) ?></td>
                                    <td class="text-center" style="text-align:auto"><?= TblJawatan::Totals($senarai->kategori) ?></td>
                                    <td class="text-center" style="text-align:auto"><?= TblJawatan::TotalKontrak($senarai->kategori) ?></td>

                                </tr>
                                
                            <?php } ?>
                            <tr>
                                <td colspan="2" class="text-center" style="text-align:auto"><?php echo "Jumlah Keseluruhan" ?></td>
                                <td class="text-center" style="text-align:auto"><?= TblJawatan::WarrantTotals() ?></td>

                            </tr>
                        <?php } else { ?>
                            <tr>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>