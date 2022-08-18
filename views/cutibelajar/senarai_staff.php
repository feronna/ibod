<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
//use app\assets\AppAsset;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

error_reporting(0);

//$bundle = yiister\gentelella\assets\Asset::register($this);
//AppAsset::register($this);

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
    $(document).ready(function () {
        $("#modal").on('hidden.bs.modal', function () {
            $('#modalContent').empty();
        });
    });
</script>
<!--- /Hide previous modal screen ---->
<!--<style>
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
</style>-->
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
            <?php echo $this->render('menu_jumlah_jfpib'); ?>   


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel"> 

            <div class="x_content">  
                <!--            <div class="x_title">
                                <h2>Staf Akademik</h2>
                                <div class="clearfix"></div>
                            </div>-->
                <div class="x_title">
                    <h4>SENARAI KAKITANGAN YANG SEDANG DALAM PENGAJIAN</h4><div  class="pull-right">
                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider2,
//                             'filterModel' => false,
//                    'summary' => '',
                        //'filterModel' => $kursusJemputan,
                        'emptyText' => 'Tiada data ditemui.',
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'BIL',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
//                                [
//                                    'label' => 'Nama',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'left',
//                                    'format' => 'raw',
//                                    'value' => 'biodata.CONm',
//                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
//                                ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'NAMA',
                                'headerOptions' => ['class' => 'column-title'],
//                             'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->where(['cb_tbl_pengajian.status'=>1])->joinWith('kakitangan.department')->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                                'value' => function($model) {
                            $ICNO = $model->icno;
                            return Html::a('<strong>' . $model->kakitangan->CONm . '</strong>') .
                                    '<br><small>' . $model->kakitangan->jawatan->nama . ' ' .
                                    '(' . $model->kakitangan->jawatan->gred . ')';
                        },
                                'format' => 'html',
                            ],
//                                [
//                                    'label' => 'GRED',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
//                                    'value' => 'kakitangan.jawatan.gred',
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                            [
                                'label' => 'PERINGKAT PENGAJIAN',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    if ($model->HighestEduLevel) {
                                        return '<small>' . $model->HighestEduLevel . '</small>';
                                    } else {
                                        return '<small>' . strtoupper($model->tahapPendidikan) . '</small>';
                                    }
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'INSTITUT PENGAJIAN',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if($model->l){
                                        
                                      return '<small>' . strtoupper($model->l->renewTempat) . '</small>';

                                        
                                    }
                                    else
                                    {

                                    return '<small>' . strtoupper($model->InstNm) . '</small>';
                                    }
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'label' => 'TEMPOH PENGAJIAN',
                                'format' => 'raw',
                                'value' => function ($model) {

                                    return '<small>' . strtoupper($model->tarikhmula) . ' HINGGA ' .
                                            strtoupper($model->tarikhtamat) .
                                            '<br> (' . $model->tempohpengajian . ')</small>';
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            [
                                'header' => 'PROFIL',
                                'headerOptions' => ['class' => 'text-center'],
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{mohon}',
                                'buttons' => [
                                    'mohon' => function($url, $model) {
                                        $ICNO = $model->icno;
                                        $url = Url::to(['kj-view-lkk', 'id' => $ICNO]);
//                                                       return 
//                                                        Html::a('<i class="fa fa-address-card fa-xs" aria-hidden="true"></i>', $url, ['title' => 'Lihat Laporan'],
//                                                            ['class' => 'btn btn-default btn-xs']); 
                                        return Html::a('<i class="fa fa-address-card" aria-hidden="true"></i>', [
                                                    '/lkk/kj-view-lkk', 'id' => $ICNO
//                                        'title' => 'personal',
                                                        ], [
                                                    'class' => 'btn btn-default btn-xs',
//                                        'target' => '_blank',
                                        ]);
                                    },
                                        ],
                                        'contentOptions' => ['class' => 'text-center'],
                                    ],
//                              
                                ],
                            ]);
                            ?> 
                        </div> <!-- x_content -->
                    </div>
                </div>
            </div>

        </div> <!-- x_content -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel"> 
                    <div class="x_content">  


                        <div class="table-responsive">

                            <?php
                            $gridColumns = [
                                ['class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    //'attribute' => 'CONm',
                                    'label' => 'NAMA PEMOHON',
                                    'headerOptions' => ['class' => 'column-title'],
                                    'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->laporID;
                                return Html::a('<strong>' . $model->kakitangan->CONm . '</strong>', ['']) . ' <br><small><b>UMSPER (' . $model->kakitangan->COOldID . ')</b></small>' . '<br><small>' . $model->kakitangan->department->fullname . '</small>' .
                                        '<br><small>' . $model->kakitangan->jawatan->nama . ' ' . $model->kakitangan->jawatan->gred;
                            },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'MAKLUMAT PENGAJIAN',
                                    'format' => 'raw',
                                    'value' => function ($model) {

                                        return
                                                '<small><b>' . strtoupper($model->pengajian->InstNm) . '</b></small><br>'
                                                . '<small><b>' . strtoupper($model->pengajian->tahapPendidikan) . '</b></small><br>'
                                                . '<small>' . strtoupper($model->pengajian->tarikhmula) .
                                                ' HINGGA ' . strtoupper($model->pengajian->tarikhtamat) .
                                                ' (' . strtoupper($model->pengajian->tempohtajaan) . ')' . '<br>' .
                                                '<b style="color:blue">TARIKH LAPOR DIRI:' . strtoupper($model->dtlapor) . '</b>';
                                    },
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                ],
                            ];



                            echo GridView::widget([
                                'dataProvider' => $urus,
                                'columns' => $gridColumns,
                                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                'beforeHeader' => [
                                    [
                                        'columns' => [],
                                        'options' => ['class' => 'skip-export'] // remove this row from export
                                    ]
                                ],
                                'toolbar' => [
                                    ['content' => '']
                                ],
                                'bordered' => true,
                                'striped' => false,
                                'condensed' => false,
                                'responsive' => true,
                                'hover' => true,
                                'panel' => [
                                    'type' => GridView::TYPE_DEFAULT,
                                    'heading' => '<h5>SENARAI KAKITANGAN YANG TELAH MELAPOR DIRI (BELUM SELESAI)</h5>',
                                ],
                            ]);
                            ?>
                </div>


            </div>
        </div>  

    </div>  
</div>