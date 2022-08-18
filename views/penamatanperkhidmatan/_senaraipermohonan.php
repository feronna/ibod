<?php

use yii\helpers\Html;
use yii\grid\GridView;
error_reporting(0);
?>


<?= $this->render('_topmenu') ?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Penamatan Perkhidmatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'No',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
                                ],
            [
                'label' => 'Nama',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Jawatan',
                'value' => 'kakitangan.jawatan.nama',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'JFPIU',
                'value' => 'kakitangan.department.shortname',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Terakhir Bekerja',
                'value' => 'tarikh_terakhirbekerja',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Permohonan',
                'value' => 'tarikh_mohon',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Status',
                'value' => 'status'.$jfpiu,
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) use ($jfpiu){
                        return Html::a('<i class="fa fa-edit"></i>', ['pengesahan'.$jfpiu, 'id'=>$data->id]);
                        
                      },
            ],
            
            
        ],
    ]); ?>
    </div>
        </div>
    </div>
    </div>
</div>