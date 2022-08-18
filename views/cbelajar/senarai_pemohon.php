<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [8,10,12], 'vars' => [
    ['label' => ''],
    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <?php
                $forms = ActiveForm::begin([
                            'action' => ['senarai'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>

                <?= $forms->field($searchModel, 'icno')->textInput()->input('name', ['placeholder' => "Nama Kakitangan"])->label(false); ?>
                <?= $forms->field($searchModel, 'status_bsm')->textInput()->input('name', ['placeholder' => "Status Kelulusan BSM"])->label(false)->widget(Select2::classname(), [
                        'data' => ['6'=> 'MENUNGGU KELULUSAN','4'=> 'DILULUSKAN', '5'=> 'DITOLAK'],
                        'options' => ['placeholder' => 'Status Kelulusan', 'class' => 'form-control col-md-7 col-xs-12',
                            ],
                            'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]);?>
                <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                <?=  DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'start_filter',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Tempoh Tamat Kontrak (Dari)'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                    ?></div>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                <?=  DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'end_filter',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Tempoh Tamat Kontrak (Hingga)'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>
                </div></div>
                <br><br><br>
                 
               
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <?php
            echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
                'options' => [
                'class' => 'table-responsive',
                    ],
            'clearBuffers' => true,
            'timeout' => 300,
            'target' => '_blank',
             'columns' => [
                [
                'class' => 'kartik\grid\SerialColumn', 
                'headerOptions' => [
                'style' => 'display: none;',
                ]
                ],
                [
                'label' => 'Nama',
                'value' => 'kakitangan.CONm',
                    
                'contentOptions' => ['style' => 'border:solid'],
                ],
                [
                'label' => 'No. IC',
                'value' => 'icno',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                ],
                [
                'label' => 'UMSPER',
                'value' => 'kakitangan.COOldID',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'label' => 'Tempoh Perkhidmatan <br> Status Kontrak',
                'value' => 'tempoh',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'label' => 'Mula Lantik',
                'attribute' => 'kakitangan.startDateLantik',
                'format' => ['date', 'php:d/m/Y'],
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'label' => 'Tamat Lantik',
                'value' => 'kakitangan.endDateLantik',
                'format' => ['date', 'php:d/m/Y'],
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'label' => 'Gred',
                'value' => 'kakitangan.jawatan.gred',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'label' => 'Jawatan',
                'value' => 'kakitangan.jawatan.nama',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'label' => 'JFPIU',
                'value' => 'kakitangan.department.fullname',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 [
                'header' => 'LNPT <br>'.(date('Y')-1),
                'value' => 'markahkeseluruhan1.markah_PP',
                     'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 [
                'header' => 'LNPT <br>'.(date('Y')-2),
                'value' => 'markahkeseluruhan2.markah_PP',
                     'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 [
                'header' => 'LNPT <br>'.(date('Y')-3),
                'value' => 'markahkeseluruhan3.markah_PP',
                     'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 [
                'header' => 'Kelayakan Tempoh Lanjutan',
                     'vAlign' => 'middle',
                        'hAlign' => 'center',
                'value' => function ($data){
                    if($data->markahkeseluruhan1->markah_PP >=85){
                        return '2 Tahun';
                    }
                    else{
                        return '1 Tahun';
                    }
                }
                 ],
                 [
                'header' => 'Perakuan KJ',
                'value' => 'tempoh_l_jfpiu',
                     'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'header' => date('Y')-'2'." Late",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y')-'2';
                          $late = 'late_'.$year;
                          return $data->kehadiran->$late;
                }],
                [
                'header' => date('Y')-'2'." Absent",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y')-'2';
                          $absent = 'absence_'.$year;
                          return $data->kehadiran->$absent;
                }],
                [
                'header' => date('Y')-'2'." Incomplete",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y')-'2';
                          $incomplete = 'incomplete_'.$year;
                          return $data->kehadiran->$incomplete;
                }],
                [
                'header' => date('Y')-'1'." Late",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y')-'1';
                          $late = 'late_'.$year;
                          return $data->kehadiran->$late;
                }],
                [
                'header' => date('Y')-'1'." Absent",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y')-'1';
                          $absent = 'absence_'.$year;
                          return $data->kehadiran->$absent;
                }],
                [
                'header' => date('Y')-'1'." Incomplete",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y')-'1';
                          $incomplete = 'incomplete_'.$year;
                          return $data->kehadiran->$incomplete;
                }],
                [
                'header' => date('Y')." Late",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y');
                          $late = 'late_'.$year;
                          return $data->kehadiran->$late;
                }],
                [
                'header' => date('Y')." Absent",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y');
                          $absent = 'absence_'.$year;
                          return $data->kehadiran->$absent;
                }],
                [
                'header' => date('Y')." Incomplete",
                'format' => 'raw',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                          $year = date('Y');
                          $incomplete = 'incomplete_'.$year;
                          return $data->kehadiran->$incomplete;
                }],
                [
                'header' => 'Total',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                'attribute'=> function($data){
                    for($i=0; $i<=2 ; $i++){
                    $tahun = date('Y')-$i;
                    $lambat ='late_'.$tahun;
                    $tidakhadir ='absence_'.$tahun;
                    $tidaklengkap ='incomplete_'.$tahun;
                    $total = $data->kehadiran->$lambat 
                            +$data->kehadiran->$tidakhadir
                            +$data->kehadiran->$tidaklengkap + $total;}
                          return $total;}],
               
                [
                'header' => 'Gaji Pokok Semasa',
                'value' => 'gajipokok',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 
                 [
                'header' => 'BIW Semasa',
                'value' => 'biw',
                     'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 [
                'header' => 'ITKA',
                'value' => 'itka',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                [
                'header' => 'ITP',
                'value' => 'itp',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
                 [
                'header' => 'BIPK',
                'value' => 'bipk',
                    'vAlign' => 'middle',
                        'hAlign' => 'center',
                 ],
            ],
                'exportConfig' => [ // set styling for your custom dropdown list items
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_EXCEL_X =>
                    [
                    'options' => ['style' => 'float: right; font-size:18px;'],
                    'label' => 'Muat turun',
                    'fontAwesome' => true,
                    'icon' => ['class'=>'fa fa-download'],
                    'config' => [
                        'methods' => [
                            'SetHeader' => ['Permohonan Pelantikan Semula Kakitangan Kontrak'],
            ]
        ],
                    ],
                    
    ],
            'showConfirmAlert' => FALSE,
            'filename' => 'pelantikan semula kontrak',
            'asDropdown' => false,
        ]);
            ?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
         
            
            <div class="x_content">
                

                <?=
                GridView::widget([
                'options' => [
                'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                        
                        [
                        'label' => 'Nama Pemohon',
                        'value' => 'kakitangan.CONm',
                         'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Jawatan',
                        'value' => 'kakitangan.jawatan.nama',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'JFPIU',
                            'attribute' => 'kakitangan.DeptId',
                        'value' => 'kakitangan.department.shortname',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'header' => 'Taraf Jawatan',
                        'attribute' => 'kakitangan.statusLantikan.ApmtStatusNm',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'header' => 'Tarikh Mula Kontrak',
                        'value' => 'startdatelantik',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Tarikh Tamat Kontrak',
                        'value' => 'enddatelantik',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                         'attribute' => 'tarikh_m',
                            'value' => 'tarikhmohon',
                        'label' => 'Tarikh Mohon',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'header' => 'LNPT terakhir',
                        'value'=>function ($data) {
                        $tahun = $data->markahkeseluruhan1->markah_PP."\n(".(date('Y')-1).")";
                        if($data->markahkeseluruhan1-markah_pp == ''){
                        $tahun = "-"."<br>(".(date('Y')-1).")";
                        }
                        return $tahun;
                      },
                    'format' => 'raw',
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
                     ],
                        [
                        'header' => 'Status Persetujuan PP',
                        'attribute' => 'statuspp',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Status Perakuan Ketua JFPIU',
                        'attribute' => 'statusjfpiu',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Status Kelulusan BSM',
                        'format' => 'raw',
                           'vAlign' => 'middle',
                        'hAlign' => 'center', 
                        'value'=>function ($data) {
                        if($data->status_bsm == '12'){
                            $checked = 'checked';
                        }
                        if($data->status_bsm == '13'){
                            $checked1 = 'checked';
                        }
                        if($data->status_bsm == '4' || $data->status_bsm == '5'){
                            return $data->statusbsm;
                        }
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                    ],
                        [
                        'label'=>'Tindakan',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                        'value'=>function ($data) {
                        //return Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_bsm", 'id' => $data->id]);
                        if($data->status!='5' && $data->terima == NULL){
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tindakan_bsm', 'id' => $data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']).
                        Html::a('<i class="fa fa-eye">', ["kontrak/permohonankontrak", 'id' => $data->id]);}
                        else{
                            return Html::a('<i class="fa fa-eye">', ["kontrak/permohonankontrak", 'id' => $data->id]);
                        }
                      },
             ],
                              [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($data) { 
                if(($data->status_bsm=='4' ||$data->status_bsm=='5')){
                return ['disabled' => 'disabled'];
                }
                return ['value' => $data->id, 'checked'=> true];
                },
            ],
                ],
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                    <?= Html::submitButton(Yii::t('app', 'Belum Memohon'), ['class' => 'btn btn-primary', 'name' => 'belummohon', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Pemohon'), ['class' => 'btn btn-primary', 'name' => 'notipemohon', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Pegawai'), ['class' => 'btn btn-primary', 'name' => 'notipegawai', 'value' => 'submit_2']) ?>
                
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
                 
            </div>
         
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
