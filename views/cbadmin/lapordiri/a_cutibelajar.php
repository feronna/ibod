 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
error_reporting(0);
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?> 
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
            <h5><strong>BAKAL MELAPOR DIRI</strong></h5>
            
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-info">BELUM ADA PELANJUTAN</span>'), ['cbadmin/belum-ada-pelanjutan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-calendar"></i> <span class="label label-success">ADA PELANJUTAN</span>'), ['cbadmin/search-cb'], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
      </div>

</div>
 <div class="tile-stats" style='padding:10px'>
                        <div class="x_content">

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>RUJUKAN NOTIFIKASI</u> </strong></font><br><br>

                                <span class="label label-default">BOLEH MOHON PELANJUTAN</span> : 
                                 <i class="btn btn-primary btn-xs fa fa-plus fa-xs" aria-hidden="true"></i><strong>
                                    
                                PERINGATAN UNTUK LAPOR DIRI ATAU BUAT PELANJUTAN TEMPOH </strong>
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-warning">
                                 
                                PERMOHONAN PELANJUTAN DITOLAK DAN WAJIB LAPOR DIRI</span> : 
                                 <i class="btn btn-danger btn-xs fa fa-exclamation-triangle fa-xs" aria-hidden="true"></i>
                                <strong>
                                    
                                PERINGATAN WAJIB LAPOR DIRI  </strong>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-success">TIADA HALANGAN UNTUK LAPOR DIRI</span> :
                                <i class="btn btn-success btn-xs fa fa-check fa-xs" aria-hidden="true"></i><strong>
                                    
                                PERINGATAN UNTUK LAPOR DIRI KEMBALI BERTUGAS </strong>
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>

                            </div>
                        </div>

                    </div>

<div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN</h2>
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/page-lapor'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div>
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
<!--                <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
         
                    <?//php
                    $form->field($model, 'jabatan_semasa')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
         
            </div>
                 -->
               
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>
                 

                <?php ActiveForm::end(); ?>
                 
            </div>
        </div>
</div>

                   
            
<div class="x_panel">
    <div class="x_title">
        <h4><strong><i class="fa fa-suitcase fa-md" style="color:purple"></i> SENARAI KAKITANGAN YANG SEDANG CUTI BELAJAR</strong></h4>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="table-responsive">

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
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->WHERE(['status'=>1])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                             'allowClear' => true
                            ],
                        ]),
                            
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                     
                    ],  
                                    
//                                    [
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
//                                [
//                'label' => 'JFPIB',
//                                                     'format' => 'raw',
//
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
//                'filter' => Select2::widget([
//                            'name' => 'jfpiu',
//                            'value' => $jfpiu,
//                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive'=>1])->all(), 'id', 'shortname'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//            ],
                                    [
                'label' => 'JFPIB',
                                                     'format' => 'raw',

                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => $jfpiu,
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->joinWith('kakitangan.department')->all(), 'kakitangan.DeptId', 'kakitangan.department.shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                                    [
                        'label' => 'PERINGKAT PENGAJIAN',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'HighestEduLevelCd',
                            'value' => isset(Yii::$app->request->queryParams['HighestEduLevelCd'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->orderBy(['HighestEduLevelRank'=>SORT_DESC])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                             'value'=>function ($model)  {
                    
                             if($model->HighestEduLevel)
                             {
                             return $model->HighestEduLevel;}
                             else
                             {
    return strtoupper($model->tahapPendidikan);
                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                      
                                
                                 [
                        'label' => 'INSTITUSI/UNIVERSITI',
                        'value' => function($model) {
                    
                    if($model->l)
                    {
                        return strtoupper($model->l->renewTempat);
                    }
                    else
                    {
                            return strtoupper($model->InstNm);
                    }
                        },
                                'vAlign' => 'middle',
                                                'hAlign' => 'center',

                    ],
                           
                        [
                        'label' => 'TARIKH TAMAT PENGAJIAN',
                        'format' => 'raw',
//                        'filter' => Select2::widget([
//                            'name' => 'tarikhtamat',
//                            'value' => isset(Yii::$app->request->queryParams['tarikhtamat'])? Yii::$app->request->queryParams['HighestEduLevelCd']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
//                            
                             'value'=>function ($model)  {
                    
                             if($model->tarikh_tamat)
                             {
                             return '<span class="label label-danger"> '. strtoupper($model->tarikhtamat). '</span>';
                             
                             }
//                          if(!$model->lanjut->icno)
//                             {
//                              var_dump($model->lanjut->icno);die;
////                                 return 
////                                 '<span class="label label-danger"> '. 
////                                  strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan). 
////                                 '</span>';
//                             }
                             else{
                                 return "-";
                             }
//                             elseif ($model->lanjutan)
//                             {
//    return strtoupper($model->tahapPendidikan);
//                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                    [
                        'label' => 'TARIKH PELANJUTAN',
                        'format' => 'raw',
                       'value'=>function ($model) {
                    
                             if($model->la)
                             {
                             return    $model->la->idlanjutan.'<br><span class="label label-default"> '. 
                              strtoupper($model->la->lanjutanedt). '</span><br>';
                              
                             
                             }

                             else{
                                 return "-";
                             }

                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                    [
                        'label'=>'PERINCIAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data)  {
                       
                        if($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['view_1', 'id' =>$data->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                               'vAlign' => 'middle',
                                                'hAlign' => 'center',
                           
                    ],
                              [
                                                    //'attribute' => 'CONm',
                                                    'label' => 'PERINGATAN',
                                                    'headerOptions' => ['class' => 'column-title text-center'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                              if($model->lapordiri)
                                              {
                                                  return '<small style="color:red"><b>'.$model->lapordiri->status.'</small></b>';
                                              }
                                              else
                                              {
                                 return 
                                               Html::a('<i class="fa fa-plus fa-xs" aria-hidden="true"></i>', [
                                        '/lkk/notifilapor',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
                                                 
                                
                                            ], [
                                        'class' => 'btn btn-primary btn-xs','title' => 'Boleh Pelanjutan'
//                                        'target' => '_blank',
                                    ]).' | '. Html::a('<i class="fa fa-exclamation-triangle fa-xs" aria-hidden="true"></i>', [
                                        '/lkk/notifilaporwajib',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
                                                 
                                
                                            ], [
                                        'class' => 'btn btn-danger btn-xs','title' => 'Wajib Lapor Diri'
//                                        'target' => '_blank',
                                    ]).' | '. Html::a('<i class="fa fa-check fa-xs" aria-hidden="true"></i>', [
                                        '/lkk/notifilaporbiasa',
//                                        'icno' =>$model->icno,
                                        'id' => $model->id,
                                                 
                                
                                            ], [
                                        'class' => 'btn btn-success btn-xs','title' => 'Lapor Diri Tiada Syarat'
//                                        'target' => '_blank',
                                    ]) ;         }                                       
//                             else
//                             {
//                                 return $model->status_pengajian;
//                             }
                                            },
                                                    'format' => 'html',
                                                      'vAlign' => 'middle',
                'hAlign' => 'center',
                                                ],
//                            [
//                                'class' => 'yii\grid\CheckboxColumn',
//                                'checkboxOptions' => function ($model, $key, $index, $column) {
//
//                                    return ['value' => $model->icno, 'id' => $model->icno, 'onclick' => 'check(this.value, this.checked)'];
//                                }
//                                    ],
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
