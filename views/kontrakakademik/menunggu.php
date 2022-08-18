<?php

use yii\helpers\Html;
use yii\grid\GridView;
error_reporting(0);
?>


<?= $this->render('/kontrak/_topmenu') ?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>List of Application</strong></h2>
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
                'label' => 'Name',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Post',
                'value' => 'kakitangan.jawatan.namaenglish',
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
                'label' => 'Date of Appointment',
                'value' => 'startdatelantik',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Date of Expiry',
                'value' => 'enddatelantik',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Last LNPT',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
                'value' => function ($data) { 
                if($data->markahlnpt(date('Y')-1) == '0'){
                    return "<div class='text-center'>-"."<br>(".(date('Y')-1).")</div>";
                            }
                else{
                    return $data->markahlnpt(date('Y')-1)."<br>(".(date('Y')-1).")";
                            }
                }
            ],
            [
                'label' => 'Date of Application',
                'value' => 'tarikhmohon',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Status Head of Program',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
                'value'=> 'statuskp'
            ],
            [
                'label' => 'Status Head of Department',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
                'value'=> 'statusdekan'
            ],
            [
                'label' => 'Action',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($data){
                          
                            if($data->status == '2'){
                        $return =  Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mtindakan_dekan', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']).
                        Html::a('<i class="fa fa-eye"></i>', ["maklumatkontrak1", 'id' => $data->id]);
                            }
                            else{
                            $return =  
                                Html::a('<i class="fa fa-eye"></i>', ["maklumatkontrak1", 'id' => $data->id]);
                            }
                            if($data->offerletter){
                                $surat = ' '. 
                                Html::a('<i class="fa fa-file"></i>', 'https://mediahost.ums.edu.my/api/v1/viewFile/'.$data->offerletter)
                                ;
                            }
                            
                            return $return.$surat;
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
    </div>
    </div>
</div>