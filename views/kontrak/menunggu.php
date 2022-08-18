<?php

use yii\helpers\Html;
use yii\grid\GridView;
error_reporting(0);
?>

<?= $this->render('/kontrak/_topmenu') ?>
<?php if($titlepentadbiran == 'Senarai Menunggu Persetujuan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $titlepentadbiran;?></strong></h2>
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
        'dataProvider' => $senaraipentadbiran,
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
                'label' => 'Nama Pemohon',
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
                'label' => 'Tarikh Mula Kontrak',
                'value' => 'startdatelantik',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Tamat Kontrak',
                'value' => 'enddatelantik',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'LNPT Terakhir',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value' => function ($data) { 
                if($data->markahlnpt(date('Y')-1) == ''){
                    return "<div class='text-center'>-"."<br>(".(date('Y')-1).")</div>";
                            }
                else{
                    return $data->markahlnpt(date('Y')-1)."<br>(".(date('Y')-1).")";
                            }
                }
            ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'tarikhmohon',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],  
            [
                'label' => 'Status',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'statuspp',
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($data){
                            if($data->status === '1'){
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mtindakan_pp', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']).
                        Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_pp", 'id' => $data->id], ['target' => '_blank']);
                            }
                            else{
                        return Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_pp", 'id' => $data->id], ['target' => '_blank']);
                            }
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
    </div>
    </div>
</div><?php }?>

<?php if($titlepentadbiran == 'Senarai Menunggu Perakuan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $titlepentadbiran;?></strong></h2>
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
        'dataProvider' => $senaraipentadbiran,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                                ],
            [
                'label' => 'Nama Pemohon',
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
                'label' => 'Tarikh Mula Kontrak',
                'value' => 'startdatelantik',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Tamat Kontrak',
                'value' => 'enddatelantik',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'LNPT Terakhir',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value' => function ($data) { 
                if($data->markahlnpt(date('Y')-1) == ''){
                    return "<div class='text-center'>-"."<br>(".(date('Y')-1).")</div>";
                            }
                else{
                    return $data->markahlnpt(date('Y')-1)."<br>(".(date('Y')-1).")";
                            }
                }
            ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'tarikhmohon',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
              [
                'label' => 'Status Persetujuan PP',
                'format' => 'raw',
                'value'=>'statuspp',
                  'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],      
            [
                'label' => 'Status Perakuan Ketua JFPIU',
                'format' => 'raw',
                'value'=> 'statusjfpiu',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($data){
                           if($data->status === '2'){
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mtindakan_jfpiu', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']).
                        Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_jfpiu", 'id' => $data->id], ['target' => '_blank']);
                           }
                           else{
                        return Html::a('<i class="fa fa-eye">', ["kontrak/tindakan_jfpiu", 'id' => $data->id], ['target' => '_blank']);
                           }
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
    </div>
    </div>
</div><?php }?>