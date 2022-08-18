<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\chartjs\ChartJs;
use app\models\Pergigian\TblYears;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>
<div class ="row">
<div class="col-md-12">
    

</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Carian</strong></h2>

<div class="clearfix"></div>
    </div>
        <div class="x_content">

                <?= Html::beginForm(['statistik-bulanan', 'tuntutan_gigi_id' => $icno], 'GET'); ?>

                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status'=>1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::dropDownList('bulan', $bulan, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br>
                <br>
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
                <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->             
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>

<div class="col-md-12"> 
    <div class="x_panel">
    <div class="x_title">    
        <h2><i class="fa fa-line-chart"></i><strong> Statistik Bulanan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?= ChartJs::widget([
    'type' => 'line',
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
            'mode' => true
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

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
 
                <br>
                <div class="row"> 
                <div class="col-xs-12 col-md-12 col-lg-12"> 
                                     
             <?= $this->render('_sub', ['dataProvider' => $dataProvider,'model' => $model,'sum' =>$sum]) ?>  
           
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
                        'showFooter' =>true,
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
                            'label' => 'Tarikh Rawatan',
                            'value' => 'used_dt',
                            
                        ],
                        [
                            'label' => 'ICNO',
                            'value' => 'icno',
                            
                        ],
                        [
                            'label' => 'Nama',
                            'value' => 'kakitangan.CONm',
                            
                        ],
                        [
                            'label' => 'Nama Klinik',
                            'value' => 'klinik.klinik_nama',
                            'footer' => 'JUMLAH TUNTUTAN (RM)',
                            
                        ],
                        [
                            'label' => 'Jumlah Tuntutan',
                            'value' => function($dataProvider) {return'RM' ." ".$dataProvider->jumlah_tuntutan ;},
                            'footer' => 'RM '.$sum,
                            
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
    </div>

    
 

