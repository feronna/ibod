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
            <p style="font-size:15px;font-weight: bold;">PENETAPAN STRUKTUR JABATAN</p> 
            <div class="clearfix"></div>
        </div>        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

        <div class="x_content"> 

  
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH KETUA : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
              <?=      
                $form->field($model, 'parent')->label(false)->  widget(Select2::classname(), [
             'data' => ArrayHelper::map(app\models\portfolio\TblSenaraiPeringkat::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptId'=>$test->DeptId])->all(), 'id', 'PekerjaNm2'),
//                         'data' => ArrayHelper::map(app\models\portfolio\TblSenaraiPeringkat::find()->joinWith('idPeringkat')->where(['dept_id' => $test->DeptId])->all(), 'id', 'PekerjaNm2'),
                    'options' => ['placeholder' => 'Pilih Nama Ketua', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
           
         
                   ?>
              
                </div>
            </div>
            

 
            
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PILIH STAF: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                 <?=        
                $form->field($model, 'icno')->label(false)->  widget(Select2::classname(), [
             'data' => ArrayHelper::map(app\models\portfolio\TblSenaraiPeringkat::find()->joinWith('kakitangan')->where(['tblprcobiodata.DeptId'=>$test->DeptId])->all(), 'id', 'PekerjaNm3'),
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
                        'label' => 'PERINGKAT KETUA',
                        'value' => function ($record) {
                if($record->refPeringkat2->no != null){
                             return $record->refPeringkat2->no. '-'. $record->refPeringkat2->nama ? 'PERINGKAT'. ' ' .$record->refPeringkat2->no. ' '.'-'.' '.$record->refPeringkat2->nama : ' ';
                }else{
                    return '';
                }    
                        }, 
                    ],
                      [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'STRUKTUR KETUA',
                         'value' => function ($record) {
                            if($record->unit_ketua == null){
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
                        'label' => 'PERINGKAT STAF',
                        'value' => function ($record) {
                     if($record->refPeringkat->no != null){
                        return $record->refPeringkat->no. '-'. $record->refPeringkat->nama ? 'PERINGKAT'. ' ' .$record->refPeringkat->no. ' '.'-'.' '.$record->refPeringkat->nama : ' ';
                        
                    }else{
                    return '';
                } 
                     }, 
                    ],
                                
                                
                       [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'STRUKTUR STAF',
                         'value' => function ($record) {
                         if($record->unit_staff == null){
                            return $record->seksyenStaf->section_details ? $record->seksyenStaf->section_details  : ' ';
                            }else{
                           return $record->unitStaf->unit_details ? $record->unitStaf->unit_details  : ' ';
                            }  
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
                            return 
                            Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'section-details'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) ;
                                    //. ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-carta', 'id' => $record->id, 'title' => 'section-details'], ['class' => 'btn btn-default']);
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