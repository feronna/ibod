<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper; 
use app\models\hronline\EduGred;
use app\models\hronline\EduSubjek; 
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Keputusan <?= $title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <div class="customer-form">
                    
                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => 'form-horizontal']]); ?> 
                <div class="row">
                    <?= $form->field($eduBM, 'ICNO')->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false); ?>
                    <?= $form->field($eduBM, 'EduLevel_id')->hiddenInput(['value'=>Yii::$app->request->get('id')])->label(false); ?>
                    <div class="form-group text-center">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bahasa Melayu</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <?= $form->field($eduBM, 'gred_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\ejobs\EduGred::find()->all(), 'id', 'grade'),
                        'options' => ['placeholder' => 'Pilih Gred', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                        </div> 
                    </div> 
                </div>

            <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 20, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $eduSubjek[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [ 
                            'gred_id',
                            'subjek_id',
                        ],
                    ]); ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                Tambah Subjek 
                                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i></button>
                            </h4>
                        </div>
                        <div class="panel-body text-center">
                            
                            <div class="container-items"><!-- widgetContainer -->
                            <?php foreach ($eduSubjek as $i => $eduSubjek): ?>
                                <div class="item">  
                                        <?php
                                             //necessary for update action.
                                            if (! $eduSubjek->isNewRecord) {
                                                echo Html::activeHiddenInput($eduSubjek, "[{$i}]id");
                                            }
                                        ?> 
                                     
                                        <div class="form-group"> 
                                            <div class="col-md-5 col-sm-5 col-xs-10"> 
                                                <?= $form->field($eduSubjek, "[{$i}]subjek_id")->label(false)->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(EduSubjek::find()->where(['EduLevel_id'=>Yii::$app->request->get('id')])->all(), 'id', 'EduSubjek'),
                                                    'options' => [
                                                        'placeholder' => 'Pilih Subjek',  
                                                        ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                            <div class="col-md-5 col-sm-5 col-xs-10">
                                                <?= $form->field($eduSubjek, "[{$i}]gred_id")->label(false)->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(EduGred::find()->all(), 'id', 'grade'),
                                                    'options' => [
                                                        'placeholder' => 'Pilih Gred',  
                                                        ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-10">
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                        </div> 
                                          
                                            

                                  
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <?= Html::submitButton($eduBM->isNewRecord ? 'Simpan' : 'Kemaskini', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>