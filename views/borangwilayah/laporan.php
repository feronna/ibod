<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use dosamigos\chartjs\ChartJs; 
use kartik\date\DatePicker;
 error_reporting(0); 
?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>
                <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', ['borang/index-laporan'], ['class' => 'btn btn-default btn-sm']) ?>
                </div>
                <div class="clearfix"></div>
            </div> 
            <div class="row">
            <div class="x_content">
                <div class="col-xs-12 col-md-12">
                    <?= Html::input('bulan', '',  'Mengunjungi Wilayah Asal', ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'disabled'=>'disabled']); ?>
                    
                </div>
                <br><br>
                
                <div class="col-xs-12 col-md-12"> 
                <?= Html::beginForm(['laporan', 'id' => $icno], 'GET'); ?>
                <div class="form-group">
                  <?=  DatePicker::widget([
                    'name' => 'tahun',
                    'value' => Yii::$app->request->queryParams['tahun'],
                    'type' => DatePicker::TYPE_INPUT,
                     'options' => ['placeholder' => 'Tahun',
                            ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy',
                        'minViewMode'=> "years"
                    ]
                ]);?> 
                </div> 
                <?= Html::dropDownList('bulan', $bulan, [ '0' => 'Show All by Year', '01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12',  'options' => [ '0' => ['Selected'=>'selected']]]); ?> 
                <br> 
                <br> 
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <?= Html::endForm(); ?>

            </div>
            </div></div>
        </div>
    </div>
</div>

<div class="row">                    
            <div class="col-xs-12 col-md-12 col-lg-12"> 
            <div class="x_panel">
            <div class="x_title">
            <h2><i class="fa fa-line-chart"></i><strong> Statistik Bulanan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            </div>
                <div class="x_content">
            
                        <?= ChartJs::widget([
                'type' => 'line', //line /bar
                'options' => [
                    'height' => 200,
                    'width' => 200
                ],
                'data' => [
                    'labels' => $label,
                    'datasets' => [
                        [
                            'label' => "Jumlah Tuntutan (RM)",
                            'backgroundColor' => "rgba(0,255,0,0.3)",
                            'borderColor' => "rgba(179,181,198,1)",
                            'pointBackgroundColor' => "rgba(179,181,198,1)",
                            'pointBorderColor' => "#fff",
                            'pointHoverBackgroundColor' => "#fff",
                            'pointHoverBorderColor' => "rgba(179,181,198,1)",
                            'data' => $data,
                        ],
                    ]
                ],
                            'clientOptions' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                        'labels' => [
                            'fontSize' => 14,
                            'fontColor' => "#425062",
                        ]
                    ],
                    'tooltips' => [
                        'enabled' => true,
                        'intersect' => true
                    ],
                    'hover' => [
                        'mode' => false
                    ],
                    'maintainAspectRatio' => false,

                ],
            ]);
            ?>

                    </div>

                </div>   
            </div>
                </div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Laporan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
 
                <br>
                <div class="row"> 
                <div class="col-xs-12 col-md-12 col-lg-12"> 
    

               <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportpentadbiran', 'tahun' => $tahun, 'bulan' => $bulan,'model' => $model]) ?> 
          
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
                                <td class="text-center"  style="text-align:center"><?php echo $model->getTotalCount($tahun,$bulan)?> </td>
                                 
                                 
                            </tr>
                         
                          
                    </table>
                </div>
                        
                        <div class="table-responsive">
                    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'showFooter' => true,
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
                            'label' => 'Nama',
                            'value' => 'kakitangan.CONm',
                                                       
                        ],
                        [
                            'label' => 'No.IC',
                            'value' => 'kakitangan.ICNO',
                            
                        ],
                        [
                           'label' => 'Date',
                           'value' => 'usedDt',
                          
                        ],
                        [
                            'label' => 'Jumlah',
                            'value' => function($dataProvider) { return 'RM' . " " . $dataProvider->jumlah ;}, 
                            'footer' => 'RM  '.$sum,
                            
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
 
 