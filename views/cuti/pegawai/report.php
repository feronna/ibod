<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\kehadiran\TblYears;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\daterange\DateRangePicker;
use kartik\export\ExportMenu;


$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); 
$start = date('Y').'-01-01';
$end = date('Y-m-d');     
?>
<div class="x_panel">
    <div class="x_title">
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?= Html::beginForm(['report'], 'GET'); ?>
        <?php echo Html::dropDownList('id', $id, ArrayHelper::map($jenis_cuti, 'jenis_cuti_id', 'jenis_cuti_catatan'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
        <br>
        <br>
        
        <?php
               
               echo '<div class="input-group drp-container">';

               echo DateRangePicker::widget([
                   'name'=>'date',
                   'value'=>"$start - $end",
                   'convertFormat'=>true,
                   'useWithAddon'=>true,
                   'pluginOptions'=>[
                       'locale'=>[
                           'format'=>'Y-m-d',
                           'separator'=>' to ',
                       ],
                       'opens'=>'left'
                   ]
                    ]);

               echo '</div>';
                ?>
        <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
       <?= Html::endForm(); ?>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-line-chart"></i>&nbsp;</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="pull-left">
                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'Nama',
                        'value' => 'kakitangan.CONm',
                    ],
                    [
                        'attribute' => 'Jenis Cuti',
                        'value' => 'jenisCuti.jenis_cuti_catatan',

                    ],
                    [
                        'attribute' => 'Cuti Mula',
                        'value' => 'start_date',
   
                    ],
                    [
                        'attribute' => 'Cuti Tamat',
                        'value' => 'end_date',
   
                    ],
                    [
                        'attribute' => 'Tempoh',
                        'value' => 'tempoh',
                    ],
                    [
                        'attribute' => 'JAFPIB',
                        'value' => 'department.shortname',
                    ],
                  
                    [
                        'attribute' => 'Remark',
                        'value' => 'remark',

                    ],
                    [
                        'attribute' => 'Attachment',
                        'format' => 'raw',

                        'value' => 'displayLinks',

                    ],
                    [
                        'attribute' => 'status',
                    ],
                    // [
                    //     'attribute' => 'external',
                    //     // 'footer' => \app\models\kehadiran\MonthData::getTotal($dataProvider->models, 'external'),
                    // ],
                ];

                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'clearBuffers' => true,
                    'filename' => 'Senarai Cuti',

                ]
            
            );
                ?>
            </div>
            
            <div class="x_content">
                <?php


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'responsiveWrap' => true,
                    'responsive' => true,
                    'hover' => true,
                    'showFooter' => true,
                    'hover' => true,
                    'striped' => false,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                    'pjax' => true,
                    'pjaxSettings' => [
                        'neverTimeout' => true,
                    ]
                ]);
                ?>

            </div>
        </div>
    </div>
</div>