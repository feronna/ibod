<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pengesahan\PengesahanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

<?= $this->render('/ln/_topmenu') ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Laporan Bertugas Rasmi Di Luar Negara (LN-2)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
<!--            <= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportpentadbiran', 'status' => $searchModel->status_surat]) ?>-->
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportsenarailn2', 'icno' => Yii::$app->request->queryParams['icno'], 'admin' => Yii::$app->request->queryParams['adminpos_id'], 'program' => Yii::$app->request->queryParams['program_id'], 'dept' => Yii::$app->request->queryParams['dept_id'], 'campus' => Yii::$app->request->queryParams['campus_id']]) ?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
   
            <div class="x_content"> 
                <?=
                GridView::widget([
                'options' => 
                    ['class' => 'table-responsive',],
                    'class' => 'table-responsive',
                    'dataProvider' => $dataProvider,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'summary' => '',
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        
                        [
                            'label' => 'Nama',
                            'format' => 'raw',
                            'value' => function($data){
                            return Html::a($data->kakitangan->CONm, ["tindakan-admin3", 'id' => $data->id] , ['target' => '_blank']);
                            },
                            'contentOptions' => ['style' => 'text-decoration: underline;'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],  
                                    
                        [
                            'label' => 'Gred & Jawatan',
                            'value' => 'kakitangan.jawatan.fname',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'value' => 'entrydate',
                            'label' => 'Tarikh Mohon',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'value' => 'datefrom',
                            'label' => 'Tarikh Pergi',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                                    
//                        [
//                            'label' => 'Status LN-1',
//                            'value' => 'statuss',
//                            'format' => 'raw',
//                            'vAlign' => 'middle',
//                            'hAlign' => 'center',
//                        ],   
                                    
                        [
                            'label' => 'Status LN-2',
                            'value' => 'statusln2',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ], 
                               
                        ],
                               
                            'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                            'resizableColumns' => true,
                            'responsive' => false,
                            'responsiveWrap' => false,
                            'floatHeader' => true,
                            'floatHeaderOptions' => ['position' => 'absolute'],
                            'resizableColumnsOptions' => ['resizeFromBody' => true]
                ]);
                ?>

            </div>
            <?php ActiveForm::end(); ?>
        </div>
</div>
</div>
