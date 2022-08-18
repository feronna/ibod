<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\grid\GridView;
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
            <p style="font-size:15px;font-weight: bold;">KETUA JABATAN/BAHAGIAN</p> 
            <div class="clearfix"></div>
        </div>        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

        <div class="x_content">    
            
                        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                  <?= $form->field($test->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 8])->textInput(['disabled' => 'disabled'])->label(false); ?>

                </div>
            </div>  
            
            
   
  
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH STRUKTUR : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
            
                                <?=
                $form->field($model, 'section_ketua')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\portfolio\RefSection::find()->where(['jabatan_id' => $test->DeptId])->all(), 'id', 'section_details'),
                    'options' => ['placeholder' => 'Pilih Struktur', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                    
                </div>
            </div>

<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH KETUA : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
              
                    
                                <?=
                $form->field($model, 'icno')->label(false)->  widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->where(['tblprcobiodata.DeptID' => $test->DeptId])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
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
                        'label' => 'Nama Ketua',
                        'value' => function ($record) {
                            return $record->ketua->CONm ? $record->ketua->CONm : ' ';
                        }, 
                    ],
                     [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Peringkat Ketua',
                        'value' => function ($record) {
                            return $record->level_ketua ? $record->level_ketua : ' ';
                        }, 
                    ],
                      [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Struktur',
                        'value' => function ($record) {
                            return $record->seksyenKetua->section_details ? $record->seksyenKetua->section_details : ' ';
                        }, 
                    ],
                
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Tindakan',
                        'value' => function ($record) {
                            return
//                            Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'chief-details'], ['class' => 'btn btn-default',
//                                        'data' => [
//                                            'confirm' => 'Anda yakin ingin padam?',
//                                            'method' => 'post',
//                                ]]) . ' ' .
                                    Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-chief', 'id' => $record->id, 'title' => 'chief-details'], ['class' => 'btn btn-default']);
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