<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\myidp\TblYears;
use kartik\widgets\Select2;

echo $this->render('/idp/_topmenu');

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>
<!--- /Hide previous modal screen ---->
<style>
a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i>&nbsp;Carian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'pantau-kehadiran',
                    //                            'options' => ['class' => 'form-horizontal'],
                    'action' => ['idp/laporan-idp-jabatan'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">

                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>
                <?php if ($isAdmin) { ?>
                    <div class="col-xs-12 col-md-3 col-lg-6">
                        <?= Select2::widget([
                            'name' => 'dept_id',
                            'value' => $dept_id,
                            // 'attribute' => 'state_2',
                            'data' => ArrayHelper::map($model_dept, 'id', 'fullname'),
                            'options' => ['placeholder' => 'PILIH JFPIB'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                <?php } ?>
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Cari', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end() ?>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>


<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
<!--            <div class="x_title">
                <h2>Staf Pentadbiran</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_title">
            <h2><strong><i class="fa fa-line-chart"></i>&nbspLaporan Prestasi IDP Tahunan Staf Pentadbiran Tahun <?= $tahun ?>
                    </strong></h2>
            <div  class="pull-right">
            <?= 
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                [
                                    'label' => 'Nama',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => 'biodata.CONm',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Gred',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'biodata.jawatan.gred',
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Mata Min <br>Kumpulan',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'mataMinKump',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Wajib Teras Universiti',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(5),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(5)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(5).'&nbsp; ('.$model->mataTerasUni.'/'.$model->getMinKompetensi(5).')',
//                                                'label' => '('.$model->mataTerasUni.'/'.$model->getMinKompetensi(5).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataTerasUni.'/'.$model->getMinKompetensi(5).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_teras_uni.'/'.$model->idp_kom_teras_uni.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Wajib Teras Skim',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(6),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(6)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(6).'&nbsp; ('.$model->mataTerasSkim.'/'.$model->getMinKompetensi(6).')',
//                                                'label' => '('.$model->mataTerasSkim.'/'.$model->getMinKompetensi(6).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataTerasSkim.'/'.$model->getMinKompetensi(6).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_teras_skim.'/'.$model->idp_kom_teras_skim.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Elektif',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(4),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(4)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(4).'&nbsp; ('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                                'label' => '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                            ]
//                                        );
//                                    },
//                                    'value' => function ($model){return '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_elektif.'/'.$model->idp_kom_elektif.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Jumlah Mata <br> Diambil Kira',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'jumlahMataAmbilKira'
                                    'value' => 'jum_mata_dikira',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Baki',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'bakii',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                            ],
                'filename' => 'Pencapaian IDP Staf - '.date('Y-m-d'),
                'clearBuffers' => true,
                'stream' => false,
                'folder' => '@app/web/files/myidp/.',
                'linkPath' => '/files/myidp/',
                'batchSize' => 10,
//                'deleteAfterSave' => true
            ]); 
            ?></div>
            <div class="clearfix"></div>
            
        </div>
            <div class="x_content">
               <?= 
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $kursusJemputan,
                            'emptyText' => 'Tiada data ditemui.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Nama',
                                    //'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{view}',
                                    'buttons' => [
                                      'view' => function ($url, $model) {
                                          return Html::a($model->biodata->CONm, $url, [
                                                      'title' => Yii::t('app', 'Papar Profil'),
                                                      'data-pjax' => 0,
                                                      'target' => "_blank",
                                          ]);
                                      },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                      if ($action === 'view') {
                                          $url ='profil?staffChosen='.$model->icno.'&year='.$model->tahun;
                                          return $url;
                                      }
                                    },
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Gred',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'biodata.jawatan.gred',
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Mata Min <br>Kumpulan',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'mataMinKump',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Wajib Teras Universiti',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(5),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(5)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(5).'&nbsp; ('.$model->mataTerasUni.'/'.$model->getMinKompetensi(5).')',
//                                                'label' => '('.$model->mataTerasUni.'/'.$model->getMinKompetensi(5).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataTerasUni.'/'.$model->getMinKompetensi(5).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_teras_uni.'/'.$model->idp_kom_teras_uni.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Wajib Teras Skim',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(6),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(6)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(6).'&nbsp; ('.$model->mataTerasSkim.'/'.$model->getMinKompetensi(6).')',
//                                                'label' => '('.$model->mataTerasSkim.'/'.$model->getMinKompetensi(6).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataTerasSkim.'/'.$model->getMinKompetensi(6).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_teras_skim.'/'.$model->idp_kom_teras_skim.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Elektif',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(4),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(4)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(4).'&nbsp; ('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                                'label' => '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                            ]
//                                        );
//                                    },
//                                    'value' => function ($model){return '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_elektif.'/'.$model->idp_kom_elektif.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Jumlah Mata <br> Diambil Kira',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'jumlahMataAmbilKira'
                                    'value' => 'jum_mata_dikira',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Baki',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'bakii',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                            ],
                        ]); ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
<!--            <div class="x_title">
                <h2>Staf Akademik</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_title">
            <h2><strong><i class="fa fa-line-chart"></i>&nbspLaporan Prestasi IDP Tahunan Staf Akademik Tahun <?= $tahun ?>
                    </strong></h2><div  class="pull-right">
            <?= 
            ExportMenu::widget([
                'dataProvider' => $dataProvider2,
                'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                [
                                    'label' => 'Nama',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => 'biodata.CONm',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Gred',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'biodata.jawatan.gred',
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Mata Min <br> Kumpulan',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'mataMinKump',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Teras',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(3),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(3)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(3).'&nbsp; ('.$model->mataTeras.'/'.$model->getMinKompetensi(3).')',
//                                                'label' => '('.$model->mataTeras.'/'.$model->getMinKompetensi(3).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataTeras.'/'.$model->getMinKompetensi(3).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_teras.'/'.$model->idp_kom_teras.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Elektif',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(4),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(4)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(4).'&nbsp; ('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                                'label' => '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_elektif.'/'.$model->idp_kom_elektif.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Umum',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(1),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(1)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(1).'&nbsp; ('.$model->mataUmum.'/'.$model->getMinKompetensi(1).')',
//                                                'label' => '('.$model->mataUmum.'/'.$model->getMinKompetensi(1).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataUmum.'/'.$model->getMinKompetensi(1).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_umum.'/'.$model->idp_kom_umum.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Jumlah Mata <br> Diambil Kira',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'jumlahMataAmbilKira',
                                    'value' => 'jum_mata_dikira',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Baki',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'bakii',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                            ],
                'filename' => 'Pencapaian IDP Staf - '.date('Y-m-d'),
                'clearBuffers' => true,
                'stream' => false,
                'folder' => '@app/web/files/myidp/.',
                'linkPath' => '/files/myidp/',
                'batchSize' => 10,
//                'deleteAfterSave' => true
            ]); 
            ?></div>
            <div class="clearfix"></div>
            
        </div>
            <div class="x_content">
               <?= 
                        GridView::widget([
                            'dataProvider' => $dataProvider2,
                            //'filterModel' => $kursusJemputan,
                            'emptyText' => 'Tiada data ditemui.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Nama',
                                    //'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{view}',
                                    'buttons' => [
                                      'view' => function ($url, $model) {
                                          return Html::a($model->biodata->CONm, $url, [
                                                      'title' => Yii::t('app', 'Papar Profil'),
                                                      'data-pjax' => 0,
                                                      'target' => "_blank",
                                          ]);
                                      },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                      if ($action === 'view') {
                                          $url ='profil?staffChosen='.$model->icno.'&year='.$model->tahun;
                                          return $url;
                                      }
                                    },
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Gred',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'biodata.jawatan.gred',
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Mata Min <br> Kumpulan',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'mataMinKump',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Teras',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(3),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(3)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(3).'&nbsp; ('.$model->mataTeras.'/'.$model->getMinKompetensi(3).')',
//                                                'label' => '('.$model->mataTeras.'/'.$model->getMinKompetensi(3).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataTeras.'/'.$model->getMinKompetensi(3).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_teras.'/'.$model->idp_kom_teras.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Elektif',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(4),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(4)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(4).'&nbsp; ('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                                'label' => '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataElektif.'/'.$model->getMinKompetensi(4).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_elektif.'/'.$model->idp_kom_elektif.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Umum',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    //'value' => 'mataTerasUni',
//                                    'value' => function ($model) {
//                                        // striped animated
//                                        return \yii\bootstrap\Progress::widget(
//                                            [
//                                                'percent' => $model->getPercentKompetensi(1),
//                                                'barOptions' => ['class' => $model->getColorKompetensi(1)],
//                                                'options' => ['class' => 'progress-success active progress-striped'],
//                                                //'label' => $model->getPbarLabel(1).'&nbsp; ('.$model->mataUmum.'/'.$model->getMinKompetensi(1).')',
//                                                'label' => '('.$model->mataUmum.'/'.$model->getMinKompetensi(1).')',
//                                            ]
//                                        );
//                                    },
                                    //'value' => function ($model){return '('.$model->mataUmum.'/'.$model->getMinKompetensi(1).')'; },
                                    'value' => function ($model){return '('.$model->idp_mata_umum.'/'.$model->idp_kom_umum.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Jumlah Mata <br> Diambil Kira',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    //'value' => 'jumlahMataAmbilKira',
                                    'value' => 'jum_mata_dikira',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Baki',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'bakii',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                            ],
                        ]); ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>