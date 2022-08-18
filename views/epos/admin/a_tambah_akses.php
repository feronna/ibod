<?php
$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
?> 

    <div class="x_panel"> 
        <div class="x_content"> 
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>  
            <div class="x_content">    
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'icno')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Pilih Nama'],
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
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?=
                        $form->field($model, 'access_level')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\utilities\epos\RefAkses::find()->all(), 'id', 'access_level'),
                            'options' => ['placeholder' => 'Pilih Level'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?> 
                    </div>
                </div>

                <div class="form-group text-center">
                    <?= Html::submitButton('Tambah', ['class' => 'btn btn-primary']) ?>
                </div>

            </div>   

            <?php ActiveForm::end(); ?> 
        </div>
    </div>
    <div class="x_panel"> 


        <div class="table-responsive">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],

                 [
                        'label' => 'Nama Kakitangan',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(app\models\utilities\epos\TblAkses::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'value' => function($model) {
//                            return ucwords(strtolower($model->biodata->CONm));
                            
                             return Html::a('<u><strong>'.strtoupper($model->kakitangan->CONm).'</strong></u>',
                             ['']). '<br><small>'.$model->kakitangan->jawatan->nama.' ('.$model->kakitangan->jawatan->gred.')<br>'
                                    ;
                                        
                        },
                        'format' => 'raw',
                    ],
                     [
                'label' => 'JFPIB',
                                                     'format' => 'raw',

                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'DeptId',
                            'value' => isset(Yii::$app->request->queryParams['DeptId'])? Yii::$app->request->queryParams['DeptId']:'',
                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive'=>1])->all(), 'id', 'shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                [
                    'label' => 'Level',
                      'filter' => Select2::widget([
                            'name' => 'access_level',
                            'value' => isset(Yii::$app->request->queryParams['access_level'])? Yii::$app->request->queryParams['access_level']:'',
                            'data' => ArrayHelper::map(\app\models\utilities\epos\RefAkses::find()->all(), 'id', 'access_level'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                    'value' => function($model) {
                        if ($model->access_level == 1) {
                            return '<span class="label label-warning">PEMOHON</span>';
                        } 
                         elseif ($model->access_level == 2) {
                            return '<span class="label label-info">ADMIN JAFPIB  </span>';
                        } 
                        elseif ($model->access_level == 3) {
                            return '<span class="label label-success">STAF ADMIN POS </span>';
                        } 
                       
                       
                    },
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                             [
                    'label' => 'Status',
                                  'filter' => Select2::widget([
                            'name' => 'status',
                            'value' => $status,
                            'data' => ['1'=>'<span class="label label-success">AKTIF</span>',
                                 '0' => '<span class="label label-info">TIDAK AKTIF</span>',
                               ],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            ],
                        ]),
                    'value' => function($model) {
                        if ($model->status == 1) {
                            return '<span class="label label-success">AKTIF</span>';
                        } 
                         elseif ($model->status == 0) {
                            return '<span class="label label-info">TIDAK AKTIF</span>';
                        } 
                         
                       
                    },
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Tindakan',
                    'value' => function($model) {
                           $url = Url::to(['update-akses', 'id' => $model->id]);
                                    return Html::button('<i class="fa fa-edit fa-lg"></i>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']).
                        Html::a('<i class="fa fa-trash"></i>', ['delete-akses', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm']);
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                        ],
                    ];



                    echo GridView::widget([
                        'dataProvider' => $staff,
                        'filterModel' => true,
                        'columns' => $gridColumns,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        'beforeHeader' => [
                            [
                                'columns' => [],
                                'options' => ['class' => 'skip-export'] // remove this row from export
                            ]
                        ],
                        'toolbar' => [
                        ],
                        'bordered' => true,
                        'striped' => false,
                        'condensed' => false,
                        'responsive' => true,
                        'hover' => true,
                        
                        'panel' => [
                            'type' => GridView::TYPE_DEFAULT,
                            'heading' => '<h2>Rekod Akses</h2>',
                        ],
                    ]);
                    ?>
        </div>

    </div> 
