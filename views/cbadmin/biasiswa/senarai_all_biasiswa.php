 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;

?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  
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
                 
//                        [
//                'label' => 'NAMA PENAJA',
//                'value'=>function ($model) {
//                    return $model->penajaan->penajaan;
//                },
//                
//                                            'format' => 'raw'
//
//                          
//            ],
                           [
                'label' => 'JENIS TAJAAN',
                'value'=>function ($data) {
                    return $data->nama_tajaan;
                },
                
                                            'format' => 'raw'

                          
            ],
               
                        
                                    
                           
                        
                                
                                     
                        
                        
                        
                    ];


?>


<div class="x_panel" >
    <div class="x_title">
        <h2>Carian Permohonan Biasiswa</h2>
        
        <p align="right"> 
<?= Html::a('Kembali', ['cbadmin/search-biasiswa'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD PERMOHONAN BIASISWA</strong></h2>
         &nbsp;
     <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Permohonan Biasiswa '.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                    ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
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
                'label' => 'KATEGORI',
                'value'=>function ($model) {
                    return $model->kakitangan->jawatan->job_category == 1? 'AKADEMIK':'PENTADBIRAN';
                },
                'filter' => Select2::widget([
                            'name' => 'category',
                            'value' => $category,
                            'data' => [1 => 'AKADEMIK', 2 => 'PENTADBIRAN'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
//                        'visible' => $role,
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblBiasiswa::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                     
                    ],
//                    [
//                        'label' => 'NAMA',
//                        'format' => 'raw',
//                        
//                        
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')'.' <br>'.$model->kakitangan->department->fullname.
//                                        ' ('.$model->kakitangan->department->shortname.')';
//                            }, 
//                                  
////                        'contentOptions' => ['style' => 'text-decoration: underline;'],
//                        'vAlign' => 'middle',
//                        
//                     
////                         'group' => true,
//                    ],
//                            
//                               [                      'label' => 'PERINGKAT PENGAJIAN',
//                       'value' => function($model) {
//                          if($model->tahapPendidikan)
//                                {
//                                return strtoupper($model->tahapPendidikan);}
//                       },
//                               'vAlign' => 'middle',
//                                               'hAlign' => 'center',
//
//                   ],
                                
//[
//                        'label' => 'PERINGKAT PENGAJIAN',
//                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'HighestEduLevelCd',
//                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
//                             'value'=>function ($model)  {
//                    
//                             if($model->HighestEduLevel)
//                             {
//                             return $model->HighestEduLevel;}
//                             else
//                             {
//    return strtoupper($model->tahapPendidikan);
//                             }
//                },
//                            
//                     
//                        'vAlign' => 'middle',
//                'hAlign' => 'center', 
//                     
//                    ],
                    [
                        'label' => 'NAMA PENAJA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'jenisCd',
                            'value' => isset(Yii::$app->request->queryParams['jenisCd'])? Yii::$app->request->queryParams['jenisCd']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\RefPenajaan::find()->all(), 'id', 'penajaan'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                        'value' => function($model) {
                                if($model->penajaan)
                                {
                            return strtoupper($model->penajaan->penajaan);
                                }
                                else{
                                    "TIADA MAKLUMAT";
                                }
                         
                        },
                                'vAlign' => 'middle',
                                                'hAlign' => 'center',

                    ],
                                [
                        'label' => 'JENIS TAJAAN',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'nama_tajaan',
                            'value' => isset(Yii::$app->request->queryParams['nama_tajaan'])? Yii::$app->request->queryParams['nama_tajaan']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblBiasiswa::find()->where(['status'=>1])->groupBy('nama_tajaan')->all(), 'nama_tajaan', 'nama_tajaan'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                        'value' => function($model) {
                            if($model->jenisCd){
                              return strtoupper($model->pengajian->tajaan->nama_tajaan);

                            }
                            else
                            {
                              return strtoupper($model->nama_tajaan);
                            }
                         
                        },
                                'vAlign' => 'middle',
                                                'hAlign' => 'center',

                    ],
//                                
//                                [
//                        'label' => 'JENIS TAJAAN',
//                        'value' => function($model) {
//                            return strtoupper($model->nama_tajaan);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
////                           [
//                'label' => 'JFPIB',
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                          
//            ],
[
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'biasiswa',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
//                                        'i'=>$model->HighestEduLevelCd,
                                
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
                                    ]) ;
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                                  'vAlign' => 'middle',
                                               'hAlign' => 'center',

                            ],
//                                [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_biasiswa', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                               'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                           
//                    ],
////                              
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'checkboxOptions' => function ($model, $key, $index, $column) {
//
//                                    return ['value' => $model->icno, 'id' => $model->icno, 'onclick' => 'check(this.value, this.checked)'];
//                                }
//                                    ],
                                ],
                                             'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => false,
                'responsive' => false,
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

                <?php
                $icno = '';
                foreach ($dataProvider->query->all() as $d) {
                    $icno = $icno . ',' . $d->icno;
                }
                ?>
                <script>
                    document.getElementsByClassName("select-on-check-all")[0].setAttribute("onclick", "selectall(this.checked)");
                    var inputs = document.getElementsByTagName('input');
                    var is_checked = false;
                    var t = '';
                    document.getElementsByClassName("select-on-check-all")[0].checked = true;
                    for (var x = 0; x < inputs.length; x++) {
                        if (inputs[x].type == 'checkbox' && inputs[x].name == 'selection[]') {
                            is_checked = inputs[x].checked;
                            if (is_checked == false) {
                                document.getElementsByClassName("select-on-check-all")[0].checked = false;
                            }
                        }
                    }
                    var data = sessionStorage.getItem('checkedcv');
                    var icno = data.split(',');
                    for (i = 0; i < icno.length; i++) {
                        var element = document.getElementById(icno[i]);
                        if (typeof (element) != 'undefined' && element != null)
                        {
                            element.checked = true;
                        }
                    }
                    function selectall(c) {
                        var icno = "<?= $icno ?>";
        var icno1 = icno.split(',');
        var data = sessionStorage.getItem('checkedcv');
        if (data == null) {
            data = '';
        }
        if (c === true) {
            for (i = 0; i < icno1.length; i++) {

                if (data.includes(icno1[i])) {
                }
                else {
                    data = data + ',' + icno1[i];
                }
            }
        }
        else {
            for (i = 0; i < icno1.length; i++) {
                if (data.includes(icno1[i])) {
                    data = data.replace(',' + icno1[i], '');
                    data = data.replace(icno1[i], '');
                }
            }

        }
        sessionStorage.setItem('checkedcv', data);
    }

    function check(val, c) {
        var data = sessionStorage.getItem('checkedcv');
        if (c === true) {
            data = data + ',' + val;
        }
        else {
            data = data.replace(',' + val, '');
            data = data.replace(val, '');
        }
        sessionStorage.setItem('checkedcv', data);
    }

    function test() {
        var data = sessionStorage.getItem('checkedcv');
        var keys = $('#w5').yiiGridView('getSelectedRows');
        window.open("data", '_blank');
    }

</script>
</div>
