<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cv\TblAccess;
?> 
<?= $this->render('menu') ?> 
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">ADD ACCESS</p>  
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
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => '....'],
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
            <div class="col-md5 col-sm-5 col-xs-12">  
                <?php
                if (TblAccess::isAdminAcademic()) {
                    $data = [7, 8];
                } else {
                    $data = [6, 9, 10];
                }

                echo $form->field($model, 'access')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefAccess::find()->where(['IN', 'id', $data])->all(), 'id', 'desc'),
                    'options' => ['placeholder' => '...', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>  
        </div>
        <?php if (TblAccess::isAdminNonAcademic()) { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Skim:  
                </label>
                <div class="col-md5 col-sm-5 col-xs-12">
                    <?=
                    $form->field($model, 'skim')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\cv\TblAds::find()
                                        ->leftJoin('hronline.gredjawatan', 'cv_ads.gred_id = gredjawatan.id')
                                        ->where(['gredjawatan.job_category' => 2])
                                        ->andWhere(['cv_ads.isActive' => 1])
                                        ->orderBy(['gredjawatan.gred' => SORT_ASC])->all(), 'id', 'DisplayJawatan'), 
                        'options' => ['placeholder' => '....', 'multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>   
            </div>
        <?php } ?>
        <div class="form-group text-center">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?> 


    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">RECORD</p>  
        <div class="clearfix"></div>
    </div>
    <div class="table-responsive">

        <?php
        if (TblAccess::isAdminNonAcademic()) {
            $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Name',
                'value' => function($model) {
                    return Html::a(ucwords(strtolower($model->biodata->CONm)), ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);;
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
                    return $model->biodata->department ? $model->biodata->department->fullname : ' ';
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
                'label' => 'Skim',
                'value' => function($model) {
                    return $model->displaySkim;
                },
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center','style' =>'width:25%'],
            ],
            [
                'label' => 'Action',
                'value' => function($model) {
                    return Html::a('<i class="fa fa-trash"></i>', ['delete-access-panel', 'id' => $model->id], ['class' => 'btn btn-danger btn-md',]);
                },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:15%'],
                    ],
                ];
        }else{
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Name',
                'value' => function($model) {
                    return Html::a(ucwords(strtolower($model->biodata->CONm)), ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);;
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
                    return $model->biodata->department ? $model->biodata->department->fullname : ' ';
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
                    return Html::a('<i class="fa fa-trash"></i>', ['delete-access-panel', 'id' => $model->id], ['class' => 'btn btn-danger btn-md',]);
                },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:15%'],
                    ],
                ];

        }

                echo GridView::widget([
                    'dataProvider' => $grid,
                    'columns' => $gridColumns,
                ]);
                ?>
    </div>
</div>