 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\export\ExportMenu;
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  
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
                         [   
                            
                            'label' => 'INSTITUT/UNIVERSITI',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->InstNm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                                 
                        [   
                            
                            'label' => 'NEGARA',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->negara->Country);
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                           [   
                            
                            'label' => 'BIDANG',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                              
                                if(($data->MajorCd == NULL) && ($data->MajorMinor != NULL))
                        {
                                return  strtoupper($data->MajorMinor);
                        }
                        elseif (($data->MajorCd != NULL) && ($data->MajorMinor != NULL))  {
                            return   strtoupper($data->MajorMinor);

                        }
                        else
                        {
                          return   strtoupper($data->major->MajorMinor);
                        }
                            },
                            'format' => 'raw'
                            
                        ],
                        
                         [   
                            
                            'label' => 'TARIKH PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->tarikhmula).' HINGGA '.strtoupper($data->tarikhtamat);
                            },
                            'format' => 'raw'
                            
                        ],            
                                  
                                     
                        
                        
                        
                    ];


?>

<div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN</h2>
        <p align="right">   <?= Html::a('Tambah', ['cbadmin/daftar-pengajian-lanjutan'], 
                        ['class' => 'btn btn-success btn-sm',    'target' => '_blank',]) ?>
                            <?= Html::a('Kembali', ['cbadmin/page-semak'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
   
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">
                

                
             <?php $form = ActiveForm::begin([
            'action' => ['search-pengajian'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

                <div class=" col-md-3 col-sm-3 col-xs-12">
                <?=
                $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cbelajar\TblPengajian::find()->where(['by'=>"LKK UPDATE"])->all(), 'icno', 'kakitangan.CONm'),
                        'options' => ['placeholder' => 'Nama'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
                
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Peringkat Pengajian', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                
               
                
                  
                
               
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
<?= Html::a('Reset', ['search-pengajian'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD PENGAJIAN DILULUSKAN [MANUAL]</strong></h2>
        &nbsp;
     <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => 'Senarai Kakitangan Cuti Belajar '.date('Y-m-d'),
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
                'dataProvider' => $dataProvider,
                
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        
                         
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                 
                     
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        
                     
                         'group' => true,
                    ],
                            
//                                [
//                        'label' => 'PENGAJIAN YANG DIPOHON',
//                        'value' => function($model) {
//                            return strtoupper($model->pengajian->HighestEduLevel);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
                                
//                                 [
//                        'label' => 'INSTITUSI/UNIVERSITI',
//                        'value' => function($model) {
//                            return strtoupper($model->pengajian->InstNm);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
//                                
//                                [
//                        'label' => 'BIASISWA YANG DIPOHON',
//                        'value' => function($model) {
//                            return strtoupper($model->nama_tajaan);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
                           [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
//                    [
//                        'label' => 'TINDAKAN',
//                        'value' => function($model) {
//                            return Html::a('<i class="fa fa-info" aria-hidden="true"></i>', [
//                                        'view-rekod-staf',
//                                        'id' => sha1($model->icno),
////                                        'title' => 'personal',
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                        'target' => '_blank',
//                                    ]) .
//                                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [
//                                        'cbadmin/delete-data?id='.$model->id,
//                                    
//                                            ], [
//                                        'class' => 'btn btn-default',
//                                                
//                                        'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//                                        
//                                  
//                                      
//                                    ]);
//                        },
//                                'format' => 'raw',
//                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
//                            ],
                                
                              [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'pengajian',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
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
//                              [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data)  {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_pengajian', 'id' => $data->id]),'style'=>'background-color: transparent; 
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
