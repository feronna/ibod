<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('menu') ?> 
    <div class="x_panel"> 
        <div class="x_title">
            <h2> Add Access</h2>  
            <div class="clearfix"></div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <div class="x_content">  
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md5 col-sm-5 col-xs-12"> 
                    <?=
                    $form->field($model, 'ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['!=','Status', 6])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Level: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12">  
                    <?=
                    $form->field($model, 'access')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cv\RefAccess::find()->all(), 'id', 'desc'),
                        'options' => ['placeholder' => '...', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>  
            </div>  
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>  
            
        </div>
    </div> 

<div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Name',
                        'value' => function($model) {
                            return ucwords(strtolower($model->biodata->CONm));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Position',
                        'value' => function($model) {
                            return $model->biodata->jawatan->fname;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Department',
                        'value' => function($model) {
                            return $model->biodata->penempatan ? $model->biodata->penempatan->department->fullname : ' ';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Level',
                        'value' => function($model) {
                            return $model->level->desc;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Action',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-trash"></i>', ['delete-access', 'id' => $model->id], ['class' => 'btn btn-danger btn-md',]) . '  ' . Html::a('<i class="fa fa-edit"></i>', ['edit-access', 'id' => $model->id], ['class' => 'btn btn-default btn-md',]);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width:15%'],
                            ],
                        ];



                        echo GridView::widget([
                            'dataProvider' => $grid,
                            'columns' => $gridColumns,
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
                                'heading' => '<h2>Record</h2>',
                            ],
                        ]);
                        ?>
            </div>