<?php
use yii\helpers\Html;
use kartik\grid\GridView;
error_reporting(0); 
?>

<?= $this->render('/ln/_topmenu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Senarai Permohonan Bertugas Rasmi Ke Luar Negara</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
            <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <?= Html::beginForm(['laporan-ln1', 'id' => $icno], 'GET'); ?>
                <?= Html::dropDownList('tahun', $tahun, ['2022' => '2022', '2021' => '2021', '2020' => '2020', '2019' => '2019', '2018' => '2018', '2017' => '2017', '2016' => '2016'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                 <br>
                 <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php // Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/report', 'model' => $model ,'tahun' => $tahun, 'bulan' => $bulan], ['class' => 'btn btn-warning', 'target' => '_blank']) ?>
                 <?= Html::endForm(); ?>
            </div>
            
            <div class="x_content">  <br>
          
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
                    'options' => ['class' => 'table-responsive' ], 
                    'columns' => [
                        [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'BIL.',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'], 
                        ],

                        [
                        'label' => 'NAMA',
                        'value' => 'kakitangan.CONm',                  
                        ],

                        [
                        'label' => 'TARIKH MOHON',
                        'value' => 'entrydate'
                        ],

                        [
                        'label' => 'GRED &  JAWATAN',
                        'value' => 'kakitangan.jawatan.fname'
                        ],

                        [
                        'label' => 'JAFPIB',
                        'value' => 'kakitangan.department.fullname'
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
 
 