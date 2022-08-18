<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use app\models\myidp\TblYears;
use app\models\myidp\Kehadiran;

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

$gridColumns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => 'Bil',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'label' => 'Kursus',
        'vAlign' => 'middle',
        'hAlign' => 'left',
        'value' => function ($data) {
            return strtoupper($data->sasaran3->tajukLatihan);
        },
        'contentOptions' => ['style' => 'width:200px;'],
    ],
    [
        'label' => 'Siri',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'value' => 'siri'
    ],
    [
        'label' => 'Tarikh',
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'format' => 'raw',
        'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
        'value' => function ($model) {
            if (($model->tarikhMula != null) && ($model->tarikhMula != 0000 - 00 - 00)) {

                $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                $formatteddate = $myDateTime->format('d/m/Y');

                $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
                $formatteddate2 = $myDateTime2->format('d/m/Y');

                if ($formatteddate == $formatteddate2) {
                    $formatteddate = $formatteddate;
                } else {
                    $formatteddate = $formatteddate . ' - ' . $formatteddate2;
                }
            } else {
                $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
            }
            return $formatteddate;
        },
        'headerOptions' => ['style' => 'width:100px'],
    ],
    [
        'label' => 'Tempat',
        'value' => function ($data) {
            return ucwords(strtolower($data->lokasiKursus));
        },
        'vAlign' => 'middle',
        'hAlign' => 'left',
        'contentOptions' => ['style' => 'width:200px;'],
    ],

    [
        'label' => 'Mata',
        'value' => 'jumlahMataIDP',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    [
        'label' => 'Status',
        'format' => 'raw',
        'value' => 'statusSiri',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ],
    // [
    //     'label' => 'Kehadiran',
    //     'value' => function ($data) {
    //         return Kehadiran::calculatePeserta($data->siriLatihanID);
    //     },
    //     'vAlign' => 'middle',
    //     'hAlign' => 'center',
    // ],
    // [
    // 'label' => 'Bahan',
    // 'vAlign' => 'middle',
    // 'hAlign' => 'center',
    // 'format' => 'raw',
    // 'value'=> function ($data){

    //               if ($data->linkBahan){
    //                 return Html::a('<i class="fa fa-external-link-square" aria-hidden="true"></i>', $data->linkBahan, ['class' => 'btn-sm btn-primary', 'target' => '_blank']);
    //               } else {
    //                 //return Html::button('<i class="fa fa-ban" aria-hidden="true"></i>', ['class' => 'btn-sm btn-danger', 'disabled' => true]);
    //                   return " ";
    //               }
    //           },
    // ],

]

?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#modal").on('hidden.bs.modal', function() {
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
                    'action' => ['idp/sasaran-skim'],
                    'method' => 'get',
                ])
                ?>

                <div class="col-xs-6 col-md-3 col-lg-2">
                    <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>

                <div class="col-xs-6 col-md-3 col-lg-2">
                    <?= Html::dropDownList('id', $id, ArrayHelper::map($modelSent, 'gred_skim', 'gred_skim'), ['prompt'=>'Pilih...', 'class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>

                <div class="col-xs-6 col-md-3 col-lg-2">
                    <?= Html::dropDownList('gred_no', $gred_no, ArrayHelper::map($modelSent2, 'gred_no', 'gred_no'), ['prompt'=>'Pilih...', 'class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>
                </div>

                <!-- <div class="col-xs-12 col-md-3 col-lg-6">
                        <?php
                        // Select2::widget([
                        //     'name' => 'dept_id',
                        //     'value' => $dept_id,
                        //     // 'attribute' => 'state_2',
                        //     'data' => ArrayHelper::map($model_dept, 'id', 'shortname'),
                        //     'options' => ['placeholder' => 'PILIH JAFPIB'],
                        //     'pluginOptions' => [
                        //         'allowClear' => true
                        //     ],
                        // ]);
                        ?>
                    </div> -->

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
        <!--        <div class="x_panel">
            <div class="x_title">
                <h2>Cari Latihan</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>  ubah kat sini 
            
            $this->render('form_search_latihan',['model'=>$model1]);
                </div>  ubah sini 
            </div>  x_content 
        </div>-->
        <div class="x_panel">
            <div class="x_title">
                <h3>
                    <span class="label label-primary" style="color: white">Senarai Kursus Sasaran <?= $tahun ?> Bagi Gred <?= $a ?></span>
                    <?=
                    ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'filename' => 'Senarai Kursus Sasaran Mengikut Gred ' . ucwords(strtoupper($a)) . ' Tahun ' . $tahun,
                        'clearBuffers' => true,
                        'stream' => false,
                        'folder' => '@app/web/files/myidp/.',
                        'linkPath' => '/files/myidp/',
                        'batchSize' => 10,
                    ]);
                    ?>




                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div>
                    <!-- ubah kat sini -->
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'showFooter' => true,
                            'showHeader' => true,
                            'layout' => "{items}\n{pager}",
                            'pager' => [
                                'firstPageLabel' => 'Halaman Pertama',
                                'lastPageLabel'  => 'Halaman Terakhir'
                            ],
                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>AKAN DIMAKLUMKAN</b></i>'],
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => $gridColumns,
                        ]);
                        ?>
                    </div>
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>