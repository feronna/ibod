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


<div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN</h2>
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/page-lapor'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">
                

                
             <?php $form = ActiveForm::begin([
            'action' => ['search-lapor'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>
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

                <div class=" col-md-3 col-sm-3 col-xs-12">
                <?=
                $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cbelajar\TblLapordiri::find()->all(), 'icno', 'kakitangan.CONm'),
                        'options' => ['placeholder' => 'Nama Kakitangan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
                
                
            </div>
                
                
                
       
                
                
                
                
                   

                
               
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
<?= Html::a('Reset', ['search-lapor'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD KAKITANGAN MELAPOR DIRI KEMBALI BERTUGAS</strong></h2>
        <div class="clearfix"></div>
    </div>
<!--    <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>-->
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'options' => [
                'class' => 'table-responsive',
                    ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'TAHUN',
                        'format' => 'raw',
                        
                        'value' => function($data){
                        $year = date('Y', strtotime($data->dt_lapordiri));
                        if($data->dt_lapordiri)
                        {
                        return Html::a($year);
                        }
                        else
                        {
                            return '-';
                        }
                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
                        
                     
                    ],
                    [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        
                        
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
                             
//                           [
//                'label' => 'JFPIB',
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
//                           [
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
                'label' => 'UNIVERSITI/INSTITUT',
                'value'=>function ($data) {
                    return $data->pengajian->InstNm;
                },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],      
                        
                       [
                'label' => 'BIDANG',
                'value'=>function ($data) {
                  
                        
                        if(($data->pengajian->MajorCd == NULL) && ($data->pengajian->MajorMinor != NULL))
                        {
                                return  strtoupper($data->pengajian->MajorMinor);
                        }
                        elseif (($data->pengajian->MajorCd != NULL) && ($data->pengajian->MajorMinor != NULL))  {
                            return   strtoupper($data->pengajian->MajorMinor);

                        }
                        else
                        {
                          return   strtoupper($data->pengajian->major->MajorMinor);
                        }

                },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],      
                        [
                'label' => 'STATUS PENGAJIAN',
                'value'=>function ($data) {
                    if(($data->status_pengajian == 1) || ($data->status_pengajian == 2) ||
                      ($data->status_pengajian == 3) || ($data->status_pengajian == 4) ||
                      ($data->status_pengajian == 5) || ($data->status_pengajian == 6) || 
                      ($data->status_pengajian == 7) || ($data->status_pengajian == 12) |($data->status_pengajian == 13))
                    
                    {
                    
                    return $data->study->status_pengajian;
                    }
                    else{
                        return $data->status_pengajian;
                    }
                },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
                        [
                'label' => 'TARIKH LAPOR DIRI',
                'value'=>function ($data) {
                    if($data->dt_lapordiri)
                    {
                    return strtoupper($data->dtlapor);
                    }
                    else
                    {
                        return "TIADA MAKLUMAT";
                    }
                },
                
                 
                'vAlign' => 'middle',
                          
            ],
[
                        'label'=>'TINDAKAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data)  {
                       
                        if($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['v_rekod', 'id' =>$data->laporID]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-md mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->laporID, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                               'vAlign' => 'middle',
                                                'hAlign' => 'center',
                           
                    ],
                              
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
