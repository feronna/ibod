<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;

echo $this->render('/idp/_topmenu');

error_reporting(0);
            
$gridColumns = [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'hAlign' => 'center',            
            ],
            [
                'label' => 'Nama Kakitangan',
                'hAlign' => 'center',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Program',
                'hAlign' => 'center',
                'value' => function ($data){
                            return strtoupper($data->namaProgram);
                            },
                'headerOptions' => ['style' => 'width:250px'],
            ],
            [
                'label' => 'Tarikh',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    if ($model->tarikhTamat != null){
                                        $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                                        $formatteddate2 = $myDateTime2->format('d/m/Y');
                                    } else {
                                        $formatteddate2 = '';
                                    }
                                    
                                    if ($formatteddate == $formatteddate2 ){
                                        $formatteddate = $formatteddate;    
                                    } else {
                                        $formatteddate = $formatteddate.' - '.$formatteddate2;
                                    }
                                    
                                } else {
                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                } 
                                return $formatteddate;
                            },
            ],
            // [
            //     'label' => 'Tempat',
            //     'value' => function ($data){
            //                 return strtoupper($data->lokasi);
            //                 },
            // ],
            [
                'label' => 'Anjuran',
                'hAlign' => 'center',
                'value' => function ($data){
                            return ucwords($data->penganjur).' - '.ucwords(strtoupper($data->namaPenganjur));
                            }
            ],
            // [
            //     'header' => 'Tarikh <br> Dipohon',
            //     'hAlign' => 'center',
            //     'value' => function ($data){
            //                     $tarikhKursus = $data->tarikhPohon;
            //                     $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
            //                     $formatteddate = $myDateTime->format('d-m-Y');
            //                     return $formatteddate;
            //                 }
            // ],
            // [
            //     'header' => 'Kompetensi <br> Dipohon',
            //     'hAlign' => 'center',
            //     'format' => 'raw',
            //     'value' => function ($data){
            //                 return $data->kompetensii;
            //                 }
            // ],
            [
                'label' => 'Tindakan',
                'hAlign' => 'center',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-eye">', ["idp/tindakan-pengesahan", 'permohonanID' => $data->permohonanID]);
                                } else {
                                    return Html::a('<i class="fa fa-edit">', ["idp/tindakan-pengesahan", 'permohonanID' => $data->permohonanID]);
                                }
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'momo',
                'checkboxOptions' => function ($model, $key, $index, $column){
                    return [
                        'value' => $model->permohonanID,
                        //'class' => 'checkId', /** Mizi style STARS */
                    ]; },
            ],
            /** example from the web */
            // [
            //     'class' => 'yii\grid\CheckboxColumn',
            //     'header' => Html::checkBox('selection_all', false, [
            //         'class' => 'select-on-check-all',
            //         'label' => 'Check All',
            //     ]),
            // ],
            
];
                            
$gridColumnsSah = [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'hAlign' => 'center',           
            ],
            [
                'label' => 'Nama Kakitangan',
                'hAlign' => 'center',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->CONm));
                            },
                'headerOptions' => ['style' => 'width:150px'],
            ],
            [
                'label' => 'Program',
                'hAlign' => 'center',
                'value' => function ($data){
                            return strtoupper($data->namaProgram);
                            },
                'headerOptions' => ['style' => 'width:250px'],
            ],
            [
                'label' => 'Tarikh',
                'hAlign' => 'center',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    if ($model->tarikhTamat != null){
                                        $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhTamat);
                                        $formatteddate2 = $myDateTime2->format('d/m/Y');
                                    } else {
                                        $formatteddate2 = '';
                                    }
                                    
                                    if ($formatteddate == $formatteddate2 ){
                                        $formatteddate = $formatteddate;    
                                    } else {
                                        $formatteddate = $formatteddate.' - '.$formatteddate2;
                                    }
                                    
                                } else {
                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                } 
                                return $formatteddate;
                            },
            ],
            // [
            //     'label' => 'Tempat',
            //     'value' => function ($data){
            //                 return strtoupper($data->lokasi);
            //                 },               
            // ],
            [
                'label' => 'Anjuran',
                'hAlign' => 'center',
                'value' => function ($data){
                            return ucwords($data->penganjur).' - '.ucwords(strtoupper($data->namaPenganjur));
                            }
            ],
            // [
            //     'header' => 'Tarikh <br> Dipohon',
            //     'hAlign' => 'center',
            //     'value' => function ($data){
            //                     $tarikhKursus = $data->tarikhPohon;
            //                     $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
            //                     $formatteddate = $myDateTime->format('d-m-Y');
            //                     return $formatteddate;
            //                 }
            // ],
            // [
            //     'header' => 'Kompetensi <br> Dipohon',
            //     'hAlign' => 'center',
            //     'format' => 'raw',
            //     'value' => function ($data){
            //                 return $data->kompetensii;
            //                 }
            // ],
            [
                'label' => ' ',
                'hAlign' => 'center',
                'format' => 'raw',
//                'contentOptions' => ['style' => 'width:120px; white-space: normal;'],
                'value'=> function ($data){
                                //return Html::a('<i class="fa fa-hand-o-right" aria-hidden="true"></i> PESERTA', ['value' => 'borangsemakanpeserta?id='.$lat2->kursusLatihanID, 'class' => 'btn-sm btn-primary btn-block']);
                                
                                if ($data->tarikhSemakanKJ){
                
                                    return Html::a('<i class="fa fa-eye">', ["idp/tindakan-pengesahan", 'permohonanID' => $data->permohonanID]);
                                } else {
                                    return Html::a('<i class="fa fa-edit">', ["idp/tindakan-pengesahan", 'permohonanID' => $data->permohonanID]);
                                }
                          },
                'headerOptions' => ['style' => 'width:100px'],
            ],
            [
                'header' => 'Tarikh <br> Semakan',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                              
                              if ($data->tarikhSemakanKJ){
                                    $tarikhKursus = $data->tarikhSemakanKJ;
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $tarikhKursus);
                                    $formatteddate = $myDateTime->format('d-m-Y');
                                
                                    return ucwords(strtolower($formatteddate));
                              
                              }
                            },
                'headerOptions' => ['style' => 'width:100px'],
                //'visible' => Yii::$app->user->can('supervisor'),
                //'visible' => 'Condition' ? true : false
            ],
            
]; 
            
?>
<style>
    .modal-dialog{
        width: 70%;
        margin : auto;
       
    }
</style>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">      
    <div class="x_title">
    <h5>Senarai Permohonan Mata IDP <h3><span class="label label-primary" style="color: white">BARU</span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['pengesahan'],
            ]);
        ?>

        <div class="table-responsive">
            <?php 
            Pjax::begin([
                // PJax options
            ]);


            echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);

                Pjax::end();
            ?>

            <?php

            if ($dataProvider->totalCount > 0) { ?>
                  <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                     <p align="right"><?= Html::submitButton('<i class="fa fa-paper-plane"></i> Hantar', 
                                    ['class' => 'btn btn-primary',
                                    'data' => ['confirm' => 'Hantar pengesahan?'],]); ?>
                     <?= Html::resetButton('<i class="fa fa-undo"></i> Reset', ['class' => 'btn btn-danger']); ?></p>
                    </div>
                    </div>
             <?php } ?>
             <?php ActiveForm::end(); ?>
        </div>

        </div>
    </div>
</div>
</div>
            
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">      
    <div class="x_title">
    <h5>Senarai Permohonan Mata IDP <h3><span class="label label-success" style="color: white">DISAHKAN</span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">           
            
        <div class="table-responsive">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderSah,
                    'emptyText' => 'Tiada permohonan ditemui.',
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsSah,
                ]);
            ?>
        </div>
            </div>
    </div>
</div>
</div>
    