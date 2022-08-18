<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>
<?= $this->render('/kontrak/_topmenu') ?>
<style>
    .kotak{
    height:100%;
    background-color: #eeeeee;
    opacity: 1; 
    border: 1px solid #ccc;
    word-wrap: break-word;
    width: auto;
    height: 34px;
    text-align: center;}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => 'tetapan',
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1,
                                'class' => 'form-horizontal form-label-left'
                            ],
                ]);
                ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Nama</label>
                <div class="col-md-6 col-sm-6 col-xs-6">

                    <input autocomplete="off"  type="text" class="form-control" name="nama" value="<?=Yii::$app->request->queryParams['nama']?>">
                    </div></div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tarikh Tamat Kontrak</label>
                <div class="col-md-3 col-sm-3 col-xs-3">

                 <?=  DatePicker::widget([
                    'name' => 'start',
                     'readonly' => true,
                    'value' => Yii::$app->request->queryParams['start'],
                    'type' => DatePicker::TYPE_INPUT,
                     'options' => ['placeholder' => '','autocomplete' => 'off'
                            ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'm/d/yyyy',
                        'clearBtn' => true
                    ]
                ]);?>
                    </div>
                    <div align="center" class="kotak col-md-1 col-sm-1 col-xs-1">
                 <p>-</p>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                 <?=  DatePicker::widget([
                    'name' => 'end',
                     'readonly' => true,
                    'value' => Yii::$app->request->queryParams['end'],
                    'type' => DatePicker::TYPE_INPUT,
                     'options' => ['placeholder' => '','autocomplete' => 'off'
                            ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'm/d/yyyy',
                        'clearBtn' => true
                    ]
                ]);?>
                </div></div>
                <div align="center" class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
    
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
         
            
            <div class="x_content">
                

                <?=
                GridView::widget([
                'options' => [
                'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'summary' => '',
//                    'rowOptions' =>function($data){
//                        $url = Url::to(['permohonankontrak', 'id' => $data->id]);
//
//                        return [
//                            'onclick' => "window.location.href='{$url}'"
//                        ];
//                    },
                    'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                        
                        [
                        'label' => 'Nama',
                        'format' => 'raw',
                        'value' => 'CONm',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Jawatan',
                        'value' => 'jawatan.nama',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'JFPIU',
                            'attribute' => 'kakitangan.DeptId',
                        'value' => 'department.shortname',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'header' => 'Tarikh Mula Kontrak',
                        'value' => 'displayStartLantik',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Tarikh Tamat Kontrak',
                        'value' => 'displayEndLantik',
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Tarikh Tutup Permohonan',
                        'value' => function ($data) {
                        if(\app\models\kontrak\TblAkses::find()->where(['icno' => $data->ICNO, 'role' => 'pemohon'])->exists()){
                        return date_format(date_create(\app\models\kontrak\TblAkses::find()->where(['icno' => $data->ICNO, 'role' => 'pemohon'])->one()->end_date), 'd F Y');}
                        else{
                            return 'Belum Buka';
                        }
                },
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'label' => 'Mesyuarat',
                        'value' => function ($data) {
                            $a = \app\models\kontrak\TblAkses::find()->where(['icno' => $data->ICNO, 'role' => 'pemohon'])->one();
                            return $a->sesi.' / '.$a->tahun;
                        },
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        
                              [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($data) { 
                return ['value' => $data->ICNO, 'checked'=> true];
                },
            ],
                ],
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                   
                    <div class="container">
                        <!-- Trigger the modal with a button -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Buka Permohonan</button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Tarikh Tutup Permohonan<span style="color: red" class="required">*</span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <?=  DatePicker::widget([
                                    'name' => 'tutup',
                                     'readonly' => true,
                                    'type' => DatePicker::TYPE_INPUT,
                                     'options' => ['placeholder' => '','autocomplete' => 'off'
                                            ],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]);?>
                                    </div>
                                </div>
                                  <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Mesyuarat<span style="color: red" class="required">*</span>
                                    </label>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="number" autocomplete="off" class="form-control" name="bil" placeholder="Bil">
                                    </div>
                                      <div class="col-md-4 col-sm-4 col-xs-12">
                                        <?=  DatePicker::widget([
                                        'name' => 'tahun',
                                        'type' => DatePicker::TYPE_INPUT,
                                         'options' => ['placeholder' => 'Tahun','autocomplete' => 'off'
                                                ],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'yyyy',
                    //                        'viewMode' => "years", 
                                            'minViewMode'=> "years"
                                        ]
                                    ]);?>
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>

                      </div>
                </div>
                 
            </div>
         
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>