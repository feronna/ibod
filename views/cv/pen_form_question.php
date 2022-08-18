<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\grid\GridView;
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php echo $this->render('menu'); ?>
        <div class="x_panel"> 

            <div class="table-responsive">   
                <?php
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'List',
                        'value' => function($model) {
                            return $model->question;
                        },
                        'format' => 'raw'
                    ],
                ];


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $Columns,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
                    ],
                    'pjax' => false,
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'showPageSummary' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Available Question - '.$subject->jawatan->fname.'</h2>',
                    ],
                ]);
                ?> 
            </div>
        </div>

        <div class="x_panel">
            <div class="x_title">
                <h2>Add New Questions : <?= $subject->subjek->subj ?></h2>  
                <div class="clearfix"></div>
            </div> 
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> Question : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($question, 'question')->textarea(array('rows' => 5, 'cols' => 5))->label(false) ?>
                </div>
            </div>

            <div class="hide"> 
                <?= $form->field($question, 'created_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($question, 'panel_icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
            </div>
            
            <div class="form-group text-center"> 
                <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']).'  '.Html::a('Cancel', ['competency'], ['class' => 'btn btn-danger btn-sm']).'  '.Html::a('Start Interview', ['interview'], ['class' => 'btn btn-primary btn-sm']); ?>   
            </div>




            <?php ActiveForm::end(); ?> 
        </div>
    </div>
</div>