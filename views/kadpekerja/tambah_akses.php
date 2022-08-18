<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use kartik\grid\GridView;
use yii\helpers\ArrayHelper; 

error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1319,1322,1324,1326], 'vars' => []]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Akses</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">ICNO<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 
            <?php // $form->field($model, 'icno')->textInput(['maxlength' => true]) ->label(false);?> 
                <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false);
                            
                        
            ?>
            </div>
        </div>
<!--        <div class="form-group" >
                        <span style="color:green;" class="required" align="centre">1 = Pegawai Keselamatan, 2 = Ketua Seksyen</span><br>

        </div>-->
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Access Level <span class="required"> *</span>
            </label><br>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php //$form->field($model, 'access_level')->textInput(['maxlength' => true]) ->label(false);?> 
                <?= $form->field($model, 'access_level')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    '1' => 'Ketua Seksyen', 
                                    '2' => 'Pegawai Tadbir',
                                    '3' => 'Pegawai Keselamatan KP29 / KP32', 
                                   
                                
                             ],
                                'options' => [
                                        'placeholder' => 'Sila Pilih'],

                            ]); ?> 
                <?php
//                $form->field($model, 'admin_post')->widget(Select2::classname(), 
//                            ['data' => ArrayHelper::map(Refaccess::find()->all(), 'access_level', 'access_type'),
//                            'options' => [
//                            'placeholder' => 'Admin Post'],
//                            ])->label(false); 
                ?>
               
              
            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
                <?php $model->isActive = 0; ?>
                <?= $form->field($model, 'isActive')->checkbox()->label(false); ?>


              
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>


<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Akses</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             
              
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Semakan Permohonan</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                        [
                            'label' => 'Nama',
                            'value' => 'biodata.CONm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                        [
                             'label' => 'No.IC',
                            'value' => 'icno',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Access Level',
                            'format' => 'raw',
                            'value' => 'access',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Active',
                            'format' => 'raw', 
                            'value' => 'activestat', 
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['kadpekerja/kemaskini', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit',
                             
                        ])       
                            .Html::a('', ['delete-access', 'id' => $list->id], [
                            'class' => 'btn btn-danger fa fa-trash',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                          
                        
                      },
                            
                        ],
                        
                        
                       
 

                    ],
                ]); ?>   
        </div>
    </div>
</div>


