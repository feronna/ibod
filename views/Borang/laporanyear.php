<?php

use yii\helpers\Html;
use kartik\grid\GridView;
 
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['laporanyear ', 'id' => $icno], 'GET'); ?>
                <?= Html::dropDownList('tahun', $tahun, ['2019' => '2019', '2018' => '2018', '2017' => '2017', '2016' => '2016', '2015' => '2015'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>

                <?= Html::dropDownList('bulan', $bulan, ['Choose Month' => 'Choose Month','01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?php // Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'model' => $model ,'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                 <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Laporan</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
 
                <br>
                <div class="row"> 
                <div class="col-xs-12 col-md-12 col-lg-12"> 
    
                  
                    <?= $this->render('_sub', ['dataProvider' => $dataProvider,'model' => $model]) ?>
                     
                    <div class="x_content">
                        <div class="table-responsive">
                   <table id = "table_wrapper" class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                       <thead><br>
                            <tr class="headings">
                                <th class="text-center">BULAN</th>
                                <th class="text-center">JAN</th>
                                <th class="text-center">FEB</th>
                                <th class="text-center">MAC</th>
                                <th class="text-center">APR</th>
                                <th class="text-center">MAY</th>
                                <th class="text-center">JUN</th>
                                <th class="text-center">JUL</th>
                                <th class="text-center">AUG</th>
                                <th class="text-center">SEP</th>
                                <th class="text-center">OCT</th>
                                <th class="text-center">NOV </th>
                                <th class="text-center">DEC</th>
                                <th class="text-center">JUMLAH</th>
                                 
                            </tr>
                        </thead>
                         
                            <tr class="headings">
                                <td class="text-center"  style="text-align:center">BILANGAN </td>
                                <?php for($i=1; $i<=12; $i++){ ?>
                                <td class="text-center"  style="text-align:center"><?php echo $model->perMonth($tahun,$i);?></td>
                                 
                                <?php } ?>
                                <td class="text-center"  style="text-align:center"><?php echo $dataProvider->getTotalCount()?> </td>
                                 
                                 
                            </tr>
                         
                          
                    </table>
                </div>
                        
                        <div class="table-responsive">
                    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                        'header' => 'Bil',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'], 
                                            ],
                        [
                            'label' => 'Date',
                            'value' => 'entrydate',
                            
                        ],
                        [
                            'label' => 'No.IC',
                            'value' => 'kakitangan.ICNO',
                            
                        ],
                        [
                            'label' => 'Nama',
                            'value' => 'kakitangan.CONm',
                            
                        ],
                        
                    ],
                           
                           
                ]); ?>
                </div>
                    </div>

                </div>
            </div>

            </div>
        </div>
    </div>
</div>
 
 