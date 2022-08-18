<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
error_reporting(0); 
?>
<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],

                        
                        [   
                            
                            'label' => 'NAMA KAKITANGAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->kakitangan->CONm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                             [   
                            
                            'label' => 'NO KAD PENGENALAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->icno));
                            },
                            'format' => 'raw'
                            
                        ],
                         [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                
                                            'format' => 'raw'

                          
            ],
                                
                                     
                        
                        
                        
                    ];


?>
<div class="row">

<?= $this->render('/cutibelajar/_topmenu') ?>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
       <p align="right">  <?= Html::a('Kembali', ['cbadmin/page'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="x_panel">
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => [''],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <div class="form-group">
                                      <div class="col-md-2 col-sm-2 col-xs-6">
                                        <?=  DatePicker::widget([
                                        'name' => 'my',
                                        'value' => $my,
                                        'type' => DatePicker::TYPE_INPUT,
                                         'options' => ['placeholder' => 'Tahun','autocomplete' => 'off'
                                                ],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'yyyy-mm',
                    //                        'viewMode' => "years", 
                                            'minViewMode'=> "months"
                                        ]
                                    ]);?>
                                    </div>
                                </div>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-legal"></i> NOMINAL DAMAGES</strong></h2> &nbsp;&nbsp;
                  <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
//                            'style'=>"float: right; font-size:18px;",
                            'filename' => 'Senarai Nominal Damages'.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                    ?>
                <br/>
<!--                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>-->
                <div class="clearfix"></div>
            </div>
           
            
            <br>
<!--             <h5>Senarai Kakitangan Akademik - Tidak Aktif Bergaji Penuh</h5>-->
            
            <div class="x_content">
                

                <?= GridView::widget([
        'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'options' => [
                'class' => 'table-responsive',
                    ],
        'dataProvider' => $dataProvider,
        'filterModel' => true,
//        'summary' => '',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
            'header' => 'No',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
                        
//                        [
//                        'label' => 'NAMA',
//                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLapordiri::find()->where(['status_pengajian'=>"BELUM SELESAI"])->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
//                            
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
//                            }, 
//                                  
//                     
////                        'value' => function($data){
////                        return Html::a($data->kakitangan->CONm).'<br/> '
////                                ;
////                        },
////                        'contentOptions' => ['style' => 'text-decoration: underline;'],
//                     
//                    ],
        
             [
                'label' => 'STATUS PERKHIDMATAN',
                   'format' => 'raw',
                         'vAlign' => 'middle',
                          'hAlign' => 'center',

                 'value'=>function ($data) {
                    return strtoupper($data->kakitangan->serviceStatus->ServStatusNm);
                },
                'filter' => Select2::widget([
                            'name' => 'khidmat',
                            'value' => $khidmat,
                            'data' => ArrayHelper::map(app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                        'label' => 'NAMA',
                        'format' => 'raw',
                                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLapordiri::find()->where(['status_pengajian'=>["BELUM SELESAI", "GAGAL PENGAJIAN", "GAGAL PENGAJIAN DAN DIBERHENTIKAN","GAGAL PENGAJIAN DAN MELETAK JAWATAN",2,4,6,3,5,7]])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        
                        
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')'.' <br>'.$model->kakitangan->department->fullname.
                                        ' ('.$model->kakitangan->department->shortname.')';
                            }, 
                                  
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        
                     
//                         'group' => true,
                    ],
                            
                      
//                         [
//                'label' => 'JFPIB',
//                                                     'format' => 'raw',
//
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                'filter' => Select2::widget([
//                            'name' => 'jfpiu',
//                            'value' => $jfpiu,
//                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//            ],
//                   [
//                'label' => 'PERINGKAT PENGAJIAN',
//                'value'=>function ($data) {
//                    return strtoupper($data->pengajian->tahapPendidikan);
//                },
//                
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                          
//            ],    
                        [
                        'label' => 'STATUS PENGAJIAN',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                             'name' => 'status_pengajian',
                            'value' => $status_pengajian,
                            'data' => [
                          'BELUM SELESAI' => 'BELUM SELESAI',
                          '7' => 'GAGAL PENGAJIAN',
                          'GAGAL PENGAJIAN DAN DIBERHENTIKAN' => 'GAGAL PENGAJIAN DIBERHENTIKAN',
                          'GAGAL PENGAJIAN DAN MELETAK JAWATAN' => 'GAGAL PENGAJIAN DAN MELETAK JAWATAN',
                           "MIA"=> 'MIA',
                           '2'=>'SEDANG MENULIS',
                           '3'=>'SEDANG TUNGGU VIVA','4'=>'TELAH HANTAR DRAF TESIS AKHIR KEPADA PENYELIA (SEMUA BAB)',
                           '5'=>'TELAH VIVA (MAJOR / MINOR CORRECTION)', '6'=>'TUNGGU KEPUTUSAN RASMI'],                          
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                             'value'=>function ($model)  {
                                
                                if($model->study->status_pengajian)
                                {
                                return Html::a('<strong>'.$model->pengajian->tahapPendidikan.'</strong>').
                                     '<br><small>'. 
                                        
                                        ucwords(strtolower($model->study->status_pengajian)).'</small>';
                                }
                                else
                                {
                                     return Html::a('<strong>'.$model->pengajian->tahapPendidikan.'</strong>').
                                     '<br><small>'. 
                                        
                                        ucwords(strtolower($model->status_pengajian)).'</small>';
                                }
//                            return strtoupper($model->pengajian->tahapPendidikan).'<br>'.
//                            $model->status_pengajian;
                                
//                                 if($pengajian->lapor->study->status_pengajian)
//                          {
//                            echo '<span class="label label-success">'.($pengajian->lapor->study->status_pengajian).'</span>';
//
//                              
//                          }
//                          else
//                          {
//                             echo '<span class="label label-danger">'.($pengajian->lapor->status_pengajian).'</span>';
//                          }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                        
                        [
                'label' => 'TEMPOH',
                'value'=>function ($data) {
                    if($data->nd_nominal)
                    {
                    return $data->tempohh;}
                     elseif ($data->dt_setuju)
                    {
                        return $data->tempohhh;
                   
                    }
//                    elseif ($data->dt_setuju)
//                    {
//                        return $data->tempohhh;
//                   
//                    }
                    elseif ($data->j_nd)
                    {
                        return '<strong><small>'.$data->tempoh1.'</strong></small>';
                   
                    }
                    else
                    {
                        return "-";
                    }
                },
//                 'filter' => Select2::widget([
//                            'name' => 'tempoh',
//                            'value' => $data->tempoh1,
//                            'data' => ["24" => "24 BULAN", "36" => "36 BULAN"],
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//               
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                       
                [
                        'label' => 'NOMINAL DAMAGES',
//                        'attribute' => 'dt_ppuu',
                        'format' => 'raw',
                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
                              'value'=>function ($data) {
                          if($data->dt_nominal)
                          {
                                 return '<i class="fa fa-exclamation-triangle fa-xs"></i> '. '<strong><small>'. strtoupper($data->dtnominal).
                                         '</strong></small><br><i class="fa fa-check fa-xs"></i> '.'<strong><small>'. strtoupper($data->dtsetuju).'</strong></strong>';
                              }
//                              elseif(!$data->dt_setuju)
//                              {
//                                 return "<strong><small>TIADA MAKLUMAT</small></strong>";
//
//                              }
                              elseif($data->dt_setuju)
                              {
                                  return '<strong><small>'. strtoupper($data->dt_setuju).'</strong></strong>';
                              }
                              else
                              {
                                  return "<strong><small>TIADA MAKLUMAT</small></strong>";
                              }
                              }
                    ],        
                        
                        
                                   [
                'label' => 'JUMLAH KUTIPAN',
                'value'=>function ($data) {
                        
                       if($data->nd_nominal)
                       {
                           return "RM".($data->j_nd * $data->tempohh);
                           
                       }
                       elseif($data->dt_setuju)
                       {
                           return "RM".($data->j_nd * $data->tempoh1);
                       }
                      else
                       {
                       return "RM".($data->j_nd * $data->tempohhh);}
                },
               
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                        [
                            'label' => 'NOMINAL DAMAGES',
//                        'attribute' => 'dt_ppuu',
                            'format' => 'raw',
                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
                            'value' => function ($data) {
                               
                                if ($data->nominal->dt_nominal) {
                                    return '<i class="fa fa-exclamation-triangle fa-xs"></i> ' . '<strong><small>' . strtoupper($data->nominal->dtnominal) .
                                            '</strong></small><br><i class="fa fa-check fa-xs"></i> ' . '<strong><small>' . strtoupper($data->dtsetuju) . '</strong></strong>';
                                }
//                              elseif(!$data->dt_setuju)
//                              {
//                                 return "<strong><small>TIADA MAKLUMAT</small></strong>";
//
//                              }
                                elseif ($data->nominal->dt_setuju) {
                                    return '<strong><small>' . strtoupper($data->nominal->dt_setuju) . '</strong></strong>';
                                } 
                                else {
                                    return "<strong><small>TIADA MAKLUMAT</small></strong>";
                                }
                            }
                        ],
                   
                  [
                        'label'=>'KEMASKINI',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) use ($nd) {
                       
                        if($nd->terima == NULL){
                        $ICNO = $nd->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_nd', 'id' => $data->laporID]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $nd->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                          'vAlign' => 'middle',
                'hAlign' => 'center',  
                    ],
//                              
                              
                              
                        
                        [
                        'label' => 'TARIKH PPUU',
                        'attribute' => 'dt_ppuu',
                        'format' => 'raw',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                              'value'=>function ($data) use ($nd) {
                          if($data->dt_ppuu)
                          {
                               return '<span class="label label-danger">'. $data->dt_ppuu. '</span>'; 
                              }
                              else
                              {
                                  return "<strong><small>TIADA MAKLUMAT</small></strong>";
                              }
                              }
                    ],
                            [
                        'label'=>'PPUU',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) use ($nd) {
                          
//                        if ($nd->dt_ppuu){
//                         return $nd->dt_ppuu;}
//                        else{
//                         return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_ppuu', 'id' => $data->laporID]),'style'=>'background-color: transparent; 
////                        border: none;', 'class' => 'fa fa-legal fa-md mapBtn']);
//                        }
                        if($nd->terima == NULL){
                        $ICNO = $nd->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_ppuu', 'id' => $data->laporID]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-legal fa-md mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                         return $data->dt_ppuu;}
                        
                      },
                          'vAlign' => 'middle',
                'hAlign' => 'center',  
                    ],
                      [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'nominal',
                                        'icno' =>$model->icno,
                                        'id' => $model->laporID,
//                                        'i'=>$model->HighestEduLevelCd,
                                
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]) ;
                            
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                                 'vAlign' => 'middle',
                'hAlign' => 'center', 
                            ],  
//                        [
//                        'label'=>'Tindakan',
//                        'format' => 'raw',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                        'value'=>function ($data) {
//                        //return Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_bsm", 'id' => $data->id]);
//                        if($data->status!='5' && $data->status!='4'){
//                       return
//                        Html::a('<i class="fa fa-edit">', ["status-perkhidmatan/view", 'icno' => $data->icno], ['target' => '_blank',  'data-toggle'=>'tooltip', 
//                        'title'=>'Ubah Status Perkhidmatan']);}
//                        else{
// 
//                            return Html::a('<i class="fa fa-edit">', ["kontrak/permohonankontrak", 'id' => $data->id], ['target' => '_blank']);
//                        }
//                      },
//             ],
//                    [
//                                            'header' => 'LKK',
//                                            'headerOptions' => ['class'=>'text-center'],
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{mohon}',
//                                            'buttons' => [
//                                                'mohon' => function($url, $model) 
//                                                {
//                                                        $ICNO = $model->icno;
//                                                        $url = Url::to(['cbadmin/view-lkk', 'id'=>$ICNO]);
//                                                       return 
//                                                        Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $url, ['title' => 'Lihat Laporan']); 
//                                                    
//                                                },
//                                                        
//                                                
//                                                
//                                        ],
//                                                
//                                            'contentOptions' => ['class' => 'text-center'],
//                                        ],
//                              [
//                'class' => 'yii\grid\CheckboxColumn',
//                'checkboxOptions' => function ($data) { 
//                if(($data->status_bsm=='4' ||$data->status_bsm=='5')){
//                return ['disabled' => 'disabled'];
//                }
//                return ['value' => $data->id, 'checked'=> true];
//                },
//            ],
                ],
                
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => false,
                'responsive' => true,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                
                 
            </div>
         

        </div>
    </div>
</div>

