<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\brp\Brp;
use dosamigos\datepicker\DatePicker;
use kartik\number\NumberControl;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <ul class="nav nav-tabs">
    <li class="nav-item active">
       <a class="nav-link " href="#tblprawd" data-toggle="tab"><?= Yii::t('app','Rekod Anugerah')?></a>
    </li>  
    
    <li class="nav-item active">
         <?php  echo '<li><a data-toggle="tab" href="#brp">Rekod BRP</a></li>'?>
    </li>
    </ul>
</div>

<div class="tab-content">
    
    <div class="tab-pane fade in active " id="tblprawd">
    <br>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Rekod Anugerah</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php               
                $gridColumns = 
                    [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($data) {
                                if(app\models\brp\Tblrscobrp::find()->where(['icno' => $data->ICNO, 'remark' => $data->AwdReason])->exists()){
                                    return ['disabled' => disabled];
                                }
                               return [ 'value' => $data->awdId];
                            },
                        ],
                                    
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',       
                        ],

                        [
                            'label' => 'Nama Pegawai',
                            'value' => 'kakitangan.CONm',  
                        ],

                        [
                            'label' => 'LPG',
                            'value' => 'awdId',          
                        ],

                        [
                            'label' => 'Keterangan',
                            'value' => 'AwdReason',      
                        ],

                    ];
                    
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false

                        'toolbar' => 
                        [
                                [
                                 
                                ],
                        ],
                                  
                        'bordered' => true,
                        'striped' => false,
                        'condensed' => false,
                        'responsive' => true,
                        'hover' => true,
                        'panel' => 
                            [
                                'type' => GridView::TYPE_DEFAULT,
                               // 'heading' => Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']).Html::submitButton(Yii::t('app', '<i class="fa fa-cancel-o"></i>&nbsp;Reset'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])
                            ], 
                        ]);
                ?>
            </div>  
        </div>
        
    <div class="row">
    <div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tambah Rekod BRP Pegawai</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jawatan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($tambah, 'jawatan_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->orderBy(['fname' => SORT_ASC])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Pilih Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mulai daripada / Kuatkuasa<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($tambah, 'tarikh_mulai')->widget(DatePicker::classname(), [
                            'value' => date('d-m-Y'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-dd'
                            ]
                        ])->label(false);?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Hingga<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'tarikh_hingga')->widget(DatePicker::classname(), [
                        'value' => date('d-m-Y'),
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-dd'
                        ]
                        ])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus (Induksi)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'tarikh_lulus')->widget(DatePicker::classname(), [
                        'value' => date('d-m-Y'),
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-dd'
                        ]
                        ])->label(false);
                    ?>
                </div>
            </div>
       
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rujukan Surat</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'rujukan_surat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Surat<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'tarikh_surat')->widget(DatePicker::classname(), [
                        'value' => date('d-m-Y'),
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-dd'
                        ]
                        ])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pencen<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'isPencen')->label(false)->widget(Select2::classname(), [
                        'data' => [1 =>'Berpencen', 0 => 'Tak Berpencen', 2 => 'Peruntukan Terbuka'],
                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                        'allowClear' => true
                        ],
                        ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gaji Pokok Sebulan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'gaji_sebulan')->widget(NumberControl::classname(), [
                        'name' => 'gaji_sebulan',
                        'pluginOptions'=>[
                        'initialize' => true,],
                        'maskedInputOptions' => [
                        'prefix' => 'RM',
                        'rightAlign' => false
                        ],
                        'options' => $saveOptions,
                        'displayOptions' => [
                        'placeholder' => 'Contoh: RM223437.04'],
                        ])->label(false);
                    ?>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
    </div>
        
    </div>    
    </div>
    
    <div class="tab-pane fade " id="brp">
    <br>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Rekod BRP</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php  
                    GridView::widget([
                    'dataProvider' => $dataProvider2,
                    'headerRowOptions' => 
                        [
                            'class' => 'kartik-sheet-style'
                        ],  
                            'resizableColumns' => true,
                            'responsive' => false,
                            'responsiveWrap' => false,
                            'hover' => true,
                            'floatHeader' => true,
                            'floatHeaderOptions' => 
                        [
                            'position' => 'absolute',
                        ],
                    ]);

                    $gridColumns = 
                    [              
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',
                        ],

                        [
                            'label' => 'Nama Pegawai',
                            'value' => 'kakitangan.CONm',
                        ],

                        [
                            'label' => 'LPG',
                            'value' => 't_lpg_id',
                        ],

                        [
                            'label' => 'Keterangan',
                            'value' => 'remark',         
                        ],

                    ];

                        echo GridView::widget([
                            'dataProvider' => $dataProvider2,
                            'columns' => $gridColumns,
                            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                            'toolbar' => 
                            [
                                [

                                ],
                            ],             
                            'bordered' => true,
                            'striped' => false,
                            'condensed' => false,
                            'responsive' => true,
                            'hover' => true,
                            'panel' => 
                            [
                                'type' => GridView::TYPE_DEFAULT,
                               // 'heading' => Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']).Html::submitButton(Yii::t('app', '<i class="fa fa-cancel-o"></i>&nbsp;Reset'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1'])
                            ],        
                    ]);
                ?>
            </div>
        </div>
    </div>
    </div>
    
</div>
 


