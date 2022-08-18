<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
?>
<?php echo $this->render('menu'); ?>  

<?php
$form = ActiveForm::begin([
            'action' => ['search-jfpiu'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]);
?> 
<div class="x_panel" >
    <div class="x_title">
        <h2><strong>SEARCH</strong></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">

                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($searchModel, 'ICNO')->textInput(['placeholder' => 'ICNO'])->label(false) ?> 
                </div>
                <div class=" col-md-4 col-sm-4 col-xs-12">
                    <?=
                    $form->field($searchModel, 'CONm')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                        ->where(['!=', 'tblprcobiodata.Status', 6])
                                        ->joinWith('jawatan')
                                        ->joinWith('statusLantikan')
                                        ->andWhere(['appointmentstatus.ApmtStatusCd' => 1])
                                        ->andWhere(['tblprcobiodata.NatStatusCd' => 1])
                                        ->andWhere(['gredjawatan.job_category' => 2])->all(), 'CONm', 'CONm'),
                        'options' => ['placeholder' => 'Name'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?> 
                </div> 
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <?=
                    $form->field($searchModel, 'DeptId')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Department', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div> 

            </div>
            <br/><br/><br/>
            <div class="form-group">

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'gredJawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['job_category'=>2])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Gred', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\PendidikanTertinggi::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Highest Education', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'Status')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                        'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?> 
                    <?= Html::a('Reset', ['search-jfpiu'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>RECORD</strong></h2>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
//                'options' => ['id' => 'cvs'],
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'NAMA PEGAWAI',
                        'value' => function($model) {
                            $mlnpt = '<span class="label label-danger">Tiada Maklumat</span> ';
                            if (!empty($model->markahlnptCVpen(1, 'Markah')) && !empty($model->markahlnptCVpen(2, 'Markah'))) {
                                if (!empty($model->markahlnptCVpen(3, 'Tahun'))) {
                                    $avg = number_format(($model->markahlnptCVpen(3, 'Markah') * 0.2) + ($model->markahlnptCVpen(2, 'Markah') * 0.35) + ($model->markahlnptCVpen(1, 'Markah') * 0.45), 2, '.', '');
                                    $mlnpt = 'Avg (3 Tahun) : ' . $avg;
                                } else {
                                    $avg = number_format(($model->markahlnptCVpen(2, 'Markah') * 0.6) + ($model->markahlnptCVpen(1, 'Markah') * 0.4), 2, '.', '');
                                    $mlnpt = 'Avg (2 Tahun) : ' . $avg;
                                }
                            }
                            return Html::a('<b>'.$model->CONm.'<br/>'.$model->jawatan->fname.'<br/>'.$model->department->fullname.'<br/>'.$model->statusLantikan->ApmtStatusNm.' | '.$mlnpt.'<br/> TEMPOH PKHIDMATAN: '.$model->servPeriodCPosition.'</b>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],  
                    [
                        'label' => 'PENGESAHAN PERKHIDMATAN',
                        'value' => function($model) {
                            $confirm = '<span class="label label-danger">Tiada Maklumat</span> ';
                            if ($model->confirmDt) {
                                $confirm = '<span class="label label-success">'.$model->getTarikh($model->confirmDt->ConfirmStatusStDt).'</span> ';
                            }

                            return $confirm;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'BEBAS TATATERTIB',
                        'value' => function($model) {
                            $dis = '<span class="label label-danger">Tiada Maklumat</span> ';
                            if ($model->usercv) {
                                if ($model->usercv->statusTatatertib() == 'Ya') {
                                    $dis = '<span class="label label-success">YA</span> ';
                                } else {
                                    $dis = '<span class="label label-danger">TIDAK</span> ';
                                }
                            }

                            return $dis;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'HARTA',
                        'value' => function($model) {
                            $Sharta = '<span class="label label-danger">Tiada Maklumat</span> ';
                            if ($model->sahHarta) { 
                                    $Sharta = '<span class="label label-success">' . $model->sahHarta->ADDeclDt . '</span>';
                              
                            }

                            return $Sharta;
                        },
                        'format' => 'raw'
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div> 

