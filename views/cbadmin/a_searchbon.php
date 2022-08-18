 <?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;

?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  


<div class="x_panel" >
    <div class="x_title">
        <h2>CARIAN KAKITANGAN</h2>
        <p align="right">  <?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">
                

                
             <?php $form = ActiveForm::begin([
            'action' => ['search-bon'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

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
                
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Pengajian Dipohon', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                
                   

                
               
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
<?= Html::a('Reset', ['search-bon'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>REKOD BON PERKHIDMATAN KAKITANGAN</strong></h2>
        <div class="clearfix"></div>
    </div>
<!--    <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>-->
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
            'header' => 'NO',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
                    [
                        'label' => 'NAMA',
                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            
                            
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
  return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->ICNO.'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>';
                                              
                            }, 
                                  
                     
//                        'value' => function($data){
//                        return Html::a($data->kakitangan->CONm).'<br/> '
//                                ;
//                        },
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                       'vAlign' => 'middle',
//                'hAlign' => 'center',
                    ],
                            
//                                [
//                        'label' => 'PENGAJIAN YANG DIPOHON',
//                        'value' => function($data) {
//                            return strtoupper($data->pendidikanTertinggi->HighestEduLevel);
//                        },
//                                'vAlign' => 'middle',
//                                                'hAlign' => 'center',
//
//                    ],
                                
//                                 [
//                        'label' => 'INSTITUSI/UNIVERSITI',
//                        'value' => function($model) {
//                            return strtoupper($model->InstNm);
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
                        
                        [
                'label' => 'STATUS',
                'value'=>function ($data) {
                    return strtoupper($data->kakitangan->serviceStatus->ServStatusNm);
                },
                
                 
                'vAlign' => 'middle',
                'hAlign' => 'center',
                          
            ],
                    [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'view-bon',
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
                            ],
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => function ($model, $key, $index, $column) {

                                    return ['value' => $model->icno, 'id' => $model->icno, 'onclick' => 'check(this.value, this.checked)'];
                                }
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
