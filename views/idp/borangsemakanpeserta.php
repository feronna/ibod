<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use app\widgets\TopMenuWidget;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\widgets\Pjax;

error_reporting(0);

/* Menu */
echo $this->render('/idp/_topmenu');

/* @var $this yii\web\View */
/* @var $model app\models\myidp\BorangPenilaianLatihan */
/* @var $form ActiveForm */

$attributes = [
    [
        'group'=>true,
        'label'=>'BAHAGIAN 1: Informasi Kursus Latihan',
        'rowOptions'=>['class'=>'table-info']
    ],
    [
        'columns' => [
            [
                'attribute'=>'kursusLatihanID', 
                'label'=>'Kursus Latihan #',
                'format'=>'raw', 
                'value'=>'<kbd>'.$modelLatihan->kursusLatihanID.'</kbd>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'tajukLatihan',
                'value'=> ucwords(strtolower($modelLatihan->sasaran3->tajukLatihan)),
                'displayOnly'=>true,
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [ 
            [
                'attribute'=>'penggubalModul', 
                'label'=>'Pemilik Modul',
                'format'=>'raw', 
                'value'=>$modelLatihan->sasaran3->penggubalModul,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'label'=>'Tahun Tawaran', 
                'format'=>'raw',
                'value'=>'<span class="text-justify">' . $modelLatihan->sasaran3->tahunTawaran  . '</span>',
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
//    [
//        'columns' => [ 
//            [   
//                'label' => 'Penceramah',
//                'format'=>'raw',
//                'value'=> ucwords(strtolower($modelLatihan->sasaran3->penceramah->displayGelaran . ' ' . $modelLatihan->sasaran3->penceramah->CONm)),
////                'type'=>DetailView::INPUT_SELECT2, 
////                'widgetOptions'=>[
////                    'data'=>ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy('CONm')->asArray()->all(), 'ICNO', 'CONm'),
////                    'options' => ['placeholder' => 'Sila Pilih ...'],
////                    'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
////                ],
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//            [
//                'label'=>'Kategori Jawatan', 
//                'format'=>'raw',
//                'value'=>'<span class="text-justify">' . $model->sasaran3->kategoriJawatanID  . '</span>',
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//        ],
//    ],
    [
        'group'=>true,
        'label'=>'BAHAGIAN 2: Informasi Siri Latihan',
        'rowOptions'=>['class'=>'table-info'],
        //'groupOptions'=>['class'=>'text-center']
    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'siriLatihanID', 
//                'label'=>'Siri Latihan ID',
//                'format'=>'raw', 
//                'value'=>'<kbd>'.$modelLatihan->siriLatihanID.'</kbd>',
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//            [
//                'attribute'=>'siri', 
//                'label'=>'Siri Latihan #',
//                'format'=>'raw', 
//                'value'=>'<kbd>'.$modelLatihan->siri.'</kbd>',
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//        ],
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'lokasi',
//                'value'=> ucwords(strtolower($modelLatihan->lokasi)),
//                'displayOnly'=>true,
//                'type'=>DetailView::INPUT_TEXTAREA, 
//                'options'=>['rows'=>4]
//                //'valueColOptions'=>['style'=>'width:90%'],
//            ],
//        ],
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'tarikhMula',
//                'value' => $modelLatihan->tarikhMula,
////                'value'=> function ($model){               
////                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
////                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
////                                    $formatteddate = $myDateTime->format('d-m-Y');
////                                } else {
////                                    $formatteddate = '<em><b>TIADA DATA</b></em>';
////                                } 
////                                return $formatteddate;
////                            },
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//            [
//                'attribute'=>'tarikhAkhir',
//                'value' => $modelLatihan->tarikhAkhir,
////                'value'=> function ($model){               
////                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
////                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
////                                    $formatteddate = $myDateTime->format('d-m-Y');
////                                } else {
////                                    $formatteddate = '<em><b>TIADA DATA</b></em>';
////                                } 
////                                return $formatteddate;
////                            },
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//        ],
//    ],
    [
        'columns' => [
            [
                'label'=>'Sinopsis Kursus',
                'format'=>'raw',
                'value'=>'<span class="text-justify"><em>' . $modelLatihan->sasaran3->sinopsisKursus  . '</em></span>',
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
            ],
        ],
    ],
//    [
//        'group'=>true,
//        'label'=>'BAHAGIAN 3: Pengesahan Kehadiran',
//        'rowOptions'=>['class'=>'table-info'],
//        //'groupOptions'=>['class'=>'text-center']
//    ],
//    [
//        'columns' => [
//            [
//                'attribute'=>'kursusLatihanID', 
//                'label'=>'Kursus Latihan #',
//                'format'=>'raw', 
//                'value'=>'<kbd>'.$model->kursusLatihanID.'</kbd>',
//                'displayOnly'=>true,
//                'valueColOptions'=>['style'=>'width:100%']
//            ],
//        ],
//    ],
];

$gridColumns = [
            [
                'label' => 'SLOT',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'value'=> 'slot',
            ],
            [
                'label' => 'PILIH SLOT',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value'=> function ($data){
                            return Html::a('<i class="fa fa-eye">', ["idp/borangsemakanpeserta", 'id' => $data->siriLatihanID, 'slotID' => $data->slotID, 'userLevel' => 'urusetiaJfpiu'], ['class' => 'btn btn-sm btn-primary'] );
                            //Html::a("Refresh", ['site/index'], ['class' => 'btn btn-lg btn-primary']);
                          },
            ],
];

$gridColumnsPeserta = [
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
//            [
//                'label' => 'Slot',
//                'value' => 'slotID'
//            ],
//            [
//                'label' => 'ID Peserta',
//                'value' => 'staffID'
//            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->gelaran->Title)).' '.ucwords(strtolower($data->peserta->CONm));
                            }
            ],
            [
                'label' => 'JFPIU',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->peserta->department->shortname));
                            }
            ],
            [
                'label' => 'Tarikh & Jam Pendaftaran',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => 'tarikhKursus',
            ],
//            [
//                'label' => 'Jenis Kursus',
//                'format' => 'raw',
//                'value' => 'jenisKursus',
//            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=> function ($data){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-peserta-jfpiu?slotID='.$data->slotID.'&staffID='.$data->staffID,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan kehadiran peserta ini?',
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
//                'label' => 'Mata Diperoleh',
//                'format' => 'raw',
//                'value' => 'sasaran9.mataSlot',
//            ],
];

?>
<div class="row"> 
    <div class="x_panel">
<!--        <div class="x_title">
            <h2><strong><i class="fa fa-info-circle"></i><?php //if ($userLevel == NULL){ echo "NULL"; } ; ?> Maklumat Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>-->
        <div class="x_title">
            <h5>Semakan Kursus <h3><span class="label label-success" style="color: white"><?= ucwords($modelLatihan->sasaran3->tajukLatihan) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
            <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $modelLatihan,
                    'attributes' => $attributes,
                    'mode' => 'view',
                    'bordered' => true,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'fadeDelay' => 1,
//                    'panel' => [
//                        'type' => 'info', 
//                        'heading' => 'Butir-Butir Latihan',
//                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
//                    ],
                    'buttons1' => false,
                    'deleteOptions'=>[ // your ajax delete parameters
                        'params' => ['id' => $modelLatihan->kursusLatihanID, 'kvdelete'=>true],
                    ],
                    'container' => ['id'=>'kv-demo'],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
                ]);
                
            ?>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Slot <h3><span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderSlot,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
            ?>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Peserta 
                <h3>
                    <span class="label label-success" style="color: white">Senarai Peserta</span>
                    <span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span>
                </h3>
            </h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?=
                GridView::widget([
                    'dataProvider' => $dataProviderKehadiran,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPeserta,
                ]);
            ?>
            
        </div>
    </div>
</div>

<?php if ($userLevel == "urusetiaJfpiu") { ?>
<div class="row">
    <div class="x_panel">
        <div class="x_title">
                <h3>
                    <span class="label label-danger" style="color: white">Tambah Peserta</span>
                    <span class="label label-primary" style="color: white">Slot <?= ucwords($modelSlot->slot) ?></span>
                </h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <?php Pjax::begin(); ?>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Peserta : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?= 
                    // With a model and without ActiveForm
                    Select2::widget([
                        'name' => 'selection',
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
                    <?= Html::submitButton('Tambah', ['class' => 'btn btn-info']) ?>
                    </p>
            
                </div>
                
            <?php Pjax::end(); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php } ?>
<?php if ($userLevel == "urusetiaLatihan") { ?>
<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Semakan Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content <?= Yii::$app->request->queryParams? collapsed:''?>">
            <?php $formx = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
                
                <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                     <?= $formx->field($program, 'statusPermohonan')->label(false)->widget(Select2::classname(), [
                    'data' => ['LAYAK' => 'LAYAK',
                                   'TIDAK LAYAK' => 'TIDAK LAYAK',],
                    'options' => ['placeholder' => 'Sila Pilih'],

                    ]); ?>
                </div>
                </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?= $formx->field($program, 'ulasanBSM')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
                </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                    
                </div>
                <div class="form-group" align="right">
                    <?= Html::submitButton(' Hantar', ['class' => 'btn btn-primary','name' => 'search2', 'value' => 'submit_2']) ?>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
    </div>
</div>
<?php } ?>