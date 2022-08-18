<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<div class="tblpraddress-form">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <?php echo $this->render('menu'); ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>Assign Competency</h2> 
                <div class="clearfix"></div> 
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> Position : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'jawatan_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cv\GredJawatan::find()
                                        ->joinWith(['temuduga'])  
                                        ->all(), 'id', 'fname'),
                        'options' => ['placeholder' => '', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> Subject : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'subj_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\ejobs\TblpSubjek::find()->all(), 'id', 'subj'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>  
            <div class="hide"> 
                <?= $form->field($model, 'panel_icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
                <?= $form->field($model, 'assign_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($model, 'assign_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
            </div>



            <div class="form-group text-center"> 
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>

    <div class="x_panel"> 
        <div class="table-responsive">   
            <?php
            $Columns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Position',
                    'value' => function($model) {
                        return $model->jawatan->fname;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Subject',
                    'value' => function($model) {
                        return $model->subjek->subj;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Panel',
                    'value' => function($model) {
                        return $model->panel->CONm;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Date/Time',
                    'value' => function($model) {
                        return $model->assign_at;
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Action',
                    'value' => function($model) {
                        if ($model->verifyMark) {
                            return '';
                        } else {
                            if ($model->panel_icno == Yii::$app->user->getId()) {
                                return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-assign-subject', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                            }
                        }
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
//                                            '{export}', 
//                                            '{toggleData}'
                ],
                'pjax' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => true,
                'showPageSummary' => true,
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                    'heading' => '<h2>Record</h2>',
                ],
            ]);
            ?> 
        </div>
    </div>


</div>
</div>