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
            <p style="font-size:15px;font-weight: bold;">TAMBAH STRUKTUR DALAM JABATAN</p> 
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
            </div>  
            
     <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA STRUKTUR:  <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
            
          
                    <?= $form->field($model, 'section_details')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    
                </div>
            </div>
            
            

            <div class="form-group text-center">
                <?= Html::submitButton($tambahSection->isNewRecord ? 'SIMPAN' : 'KEMASKINI', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?> 
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
                        'label' => 'SENARAI STRUKTUR',
                        'value' => function ($record) {
                            return $record->section_details ? $record->section_details : ' ';
                        }, 
                    ],
                                                     
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-carta', 'id' => $record->id, 'title' => 'tambah-section'], ['class' => 'btn btn-default']);
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
