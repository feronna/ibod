<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\grid\GridView;
error_reporting(0);
?> <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">UNIT DALAM JABATAN</p> 
            <div class="clearfix"></div>
        </div>        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

        <div class="x_content"> 
             
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">LEVEL KETUA: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                  
                    <?php
                                echo $form->field($model,'level_ketua')->
                                dropDownList([
                                              '1' =>'1',
                                              '2' => '2',
                                              '3' => '3',
                                              '4' => '4',
                                    '5' => '5',
                                    '6' => '6',
                                    '7' => '7',
                                    '8' => '8',
                                    '9' => '9',
                                    '10' => '10'
                                    
                                            ],['prompt'=>'Pilih Level Ketua'])->label(false);
?>
                </div>
            </div>
<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">SEKSYEN KETUA: 
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
            
                                <?=
                $form->field($model, 'section_ketua')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefSection::find()->where(['jabatan_id' => $test->DeptId])->all(), 'id', 'section_details'),
                    'options' => ['placeholder' => 'Pilih Seksyen Ketua', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                    
                </div>
            </div>
            
            
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UNIT KETUA: 
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
            
                                <?=
                $form->field($model, 'unit_ketua')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $test->DeptId])->all(), 'id', 'unit_details'),
                    'options' => ['placeholder' => 'Pilih Seksyen Ketua', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                    
                </div>
            </div> 
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KETUA: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                           <?=
                $form->field($model, 'parent')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Nama Ketua', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                </div>
            </div>  
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">LEVEL STAF: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                  
                    <?php
                                echo $form->field($model,'level_staff')->
                                dropDownList([
                                              '1' =>'1',
                                              '2' => '2',
                                              '3' => '3',
                                              '4' => '4',
                                      '5' => '5',
                                      '6' => '6',
                                      '7' => '7',
                                      '8' => '8',
                                      '9' => '9',
                                      '10' => '10'
                                            ],['prompt'=>'Pilih Level Staf '])->label(false);
?>
                </div>
            </div>
           <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UNIT STAF: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
            
              <?=
                $form->field($model, 'unit_staff')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $test->DeptId])->all(), 'id', 'unit_details'),
                    'options' => ['placeholder' => 'Pilih Unit Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                    
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA STAF: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                           <?=
                $form->field($model, 'icno')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Nama Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                </div>
            </div>  

            <div class="form-group text-center">
                <?= Html::submitButton($model->isNewRecord ? 'SIMPAN' : 'KEMASKINI', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?> 
        </div>
    </div>


    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">REKOD</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $record,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                     [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'LEVEL KETUA',
                        'value' => function ($record) {
                            return $record->level_ketua ? $record->level_ketua : ' ';
                        }, 
                    ],
                                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'SEKSYEN KETUA / UNIT KETUA',
                        'value' => function ($record) {
                            if($record->section_ketua != NULL){
                                return $record->seksyenKetua->section_details ? $record->seksyenKetua->section_details  : ' ';
                            }else{
                               
                            return $record->unitKetua->unit_details ? $record->unitKetua->unit_details  : ' ';
                            }
                            }, 
                    ],
                     [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'NAMA KETUA',
                        'value' => function ($record) {
                            return $record->ketua->CONm ? $record->ketua->CONm : ' ';
                        }, 
                    ],
                                
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'LEVEL STAF',
                        'value' => function ($record) {
                            return $record->level_staff ? $record->level_staff : ' ';
                        }, 
                    ],
                      
                     [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'UNIT STAF',
                        'value' => function ($record) {
                            return $record->namaUnit->unit_details ? $record->namaUnit->unit_details: ' ';
                        }, 
                    ],
                                
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'NAMA STAF',
                        'value' => function ($record) {
                            return $record->kakitangan->CONm ? $record->kakitangan->CONm : ' ';
                        }, 
                    ],
                  
                  
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'unit-details'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-carta', 'id' => $record->id, 'title' => 'unit-details'], ['class' => 'btn btn-default']);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center','width' => '130px'],
                            ],
                        ],
                    ]);
                    ?> 
                </div> 
            </div>


            
</div>
</div>