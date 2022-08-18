<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\form\ActiveForm;
use yii\helpers\Html;

echo $this->render('/idp/_topmenu');

$gridColumnsJemputan = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtolower($data->biodata->gelaran->Title)).' '.ucwords(strtolower($data->biodata->CONm));
                            }
            ],
            [
                'label' => 'JFPIU',
                'format' => 'raw',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                            }
            ],
//            [
//                'label' => 'Jenis Kursus',
//                'format' => 'raw',
//                'value' => 'jenisKursus',
//            ],
            [
                'label' => 'Tarikh Jemputan',
                'format' => 'raw',
                'value' => 'tarikhPermohonan',
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=> function ($data){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-permohonan?siriID='.$data->siriLatihanID.'&staffID='.$data->staffID,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin membatalkan jemputan ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Batal'),]
                                          
                                    );
                          },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
//            [
//                'label' => 'Status Permohonan',
//                'format' => 'raw',
//                'value' => 'statusPermohona',
//            ],
//            [
//                'label' => 'Pengesahan Kehadiran',
//                'format' => 'raw',
//                'value' => 'sahHadirbyStaf',
//            ],
];

?>

<div class="clearfix"></div> 
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Kursus <h3><span class="label label-success" style="color: white"><?= ucwords($modelSiriLatihan->sasaran3->tajukLatihan).' Siri '.ucwords(strtolower($modelSiriLatihan->siri)) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

        </div>
    </div>
</div>

<div class="clearfix"></div> 
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h5>Senarai <h3><span class="label label-primary" style="color: white">Jemputan</span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?php Pjax::begin(); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderJemputan,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsJemputan,
                ]);
            ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>

<div class="clearfix"></div> 
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h3><span class="label label-danger" style="color: white">Tambah Jemputan</span></h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <?php Pjax::begin(); ?>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-4">Jemputan : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?= 
                    // With a model and without ActiveForm
                    Select2::widget([
                        'name' => 'momo',
                        'data' => $allStaf,
                        'options' => ['placeholder' => 'Sila pilih...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                    ]);
                    ?>
                    </div>
                    <p align="left">
                    <?= Html::submitButton('Jemput', ['class' => 'btn btn-info']) ?>
                    </p>
            
                </div>
                
            <?php Pjax::end(); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

