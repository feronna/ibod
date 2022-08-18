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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                    <?=
                    $form->field($model, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->where(['tblprcobiodata.DeptID' => $test->DeptId])->all(), 'ICNO', 'CONm'),
                        'options' => ['multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?> 
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                    <?=
                    $form->field($model, 'jabatan_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Department::find()->joinWith('biodata')->where(['tblprcobiodata.DeptID' => $test->DeptId])->all(), 'id', 'fullname'),
//                        'options' => ['multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true,
                        'disabled'=> true,
                        ],
                    ])->label(false);
                    ?> 
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Unit/Seksyen/Bahagian: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12"> 
                    <?= $form->field($model, 'unit')->textInput()->label(false); ?>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tugasan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12"> 
                    <?= $form->field($model, 'tugasan')->textarea(['rows' => 3])->label(false); ?>
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
                        'label' => 'Nama',
                        'value' => function ($record) {
                            return $record->kakitangan->CONm ? $record->kakitangan->CONm : ' ';
                        }, 
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Tugasan',
                        'value' => function ($record) {
                            return $record->tugasan ? $record->tugasan : ' ';
                        }, 
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'Tindakan',
                        'value' => function ($record) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'carta-details'], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-carta', 'id' => $record->id, 'title' => 'carta-details'], ['class' => 'btn btn-default']);
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