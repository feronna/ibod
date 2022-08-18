<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
?>
<?= $this->render('_topmenu') ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => [''],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <div class="form-group">
                                      <div class="col-md-2 col-sm-2 col-xs-6">
                                        <?=  DatePicker::widget([
                                        'name' => 'my',
                                        'value' => $my,
                                        'type' => DatePicker::TYPE_INPUT,
                                         'options' => ['placeholder' => 'Tahun','autocomplete' => 'off'
                                                ],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'M yyyy',
                    //                        'viewMode' => "years", 
                                            'minViewMode'=> "months"
                                        ]
                                    ]);?>
                                    </div>
                                </div>
                 
               
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-users"></i> Staff's detail</strong></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    
                    <form id="w0" class="form-horizontal form-label-left" action="/basic/web/index.php?r=kehadiran%2Fremark&amp;id=51" method="post">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->CONm ?>" disabled="">

                                <div class="help-block"></div>
                            </div>                
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Position
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->jawatan->fname ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">J / F / P / I / U
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->department->fullname ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobile phone number
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->COHPhoneNo ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mobile phone number 2
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->displayPhone2 ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Office phone number
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->COOffTelNo ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext number
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->COOffTelNoExtn ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext number 2
                            </label>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $biodata->COOffTelNoExtn2 ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Month Year
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group field-tblrekod-tarikh">

                                    <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $my ?>" disabled="">


                                    <div class="help-block"></div>
                                </div>                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div class="x_panel">
    <div class="x_title">
                <h2><strong><i class="fa fa-plus-square"></i> Self Health Declaration Report</strong></h2>
                <div class="clearfix"></div>
            </div>
    <div class="x_content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'options' => [
                'class' => 'table-responsive',
                    ],
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            [
                'label' => 'Date',
                'value'=>function ($data) {
                    return date_format(date_create($data->date), 'd M Y');
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Time',
                'value'=>function ($data) {
                    return date_format(date_create($data->date), 'h:i:s a');
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Day',
                'value'=>function ($data) {
                    return date_format(date_create($data->date), 'D');
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Have symptoms Fever, cough, or shortness of breath',
                'format' => 'raw',
                'value'=>function ($data) {
                    if($data->health_status){
                    return $data->health_status === 1? '<span class="label label-success">No</span>': '<span class="label label-danger">Yes</span>';}
                    else{
                        return '-';
                    }
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
              'label' => 'Temperature (°C)',
                'format' => 'raw',
               'value'=> 'suhu',
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [   
                'label' => 'Status',
                'format' => 'raw',
                'value'=>'status',
                'vAlign' => 'middle',
                'hAlign' => 'center',],
            [
                'label' => 'Treatment status',
                'format' => 'raw',
                'value'=>function ($data){
                            return $data->statusprw.'<br>'.$data->places;
                        
                      },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
        ],
                    
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'], 
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
    ]); ?>
    </div>
</div>