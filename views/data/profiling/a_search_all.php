<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\form\ActiveForm;
use app\models\cv\TblAccess;

$request = Yii::$app->request;

?>

<?php
$form = ActiveForm::begin([
    'action' => ['search-all'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1
    ],
]);
?>
<div class="row">

<div class="col-md-12 col-sm-12 col-xs-12 ">
    <p align="right">  <?= Html::a('Kembali', ['data/index'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

    <div class="x_title">
            <h5><strong>SENARAI KESELURUHAN</strong></h5>
            
            <div class="clearfix"></div>
        </div>

         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-info">GRED 48-54</span>'), ['data/search'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-success">KESELURUHAN</span>'), ['data/search-all'], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
      </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">CARIAN</p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">

                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($searchModel, 'ICNO')->textInput(['placeholder' => 'ICNO'])->label(false) ?>
                </div>
                <div class=" col-md-4 col-sm-4 col-xs-12">
                    <?php

                    if (TblAccess::isAdminDataOwner()) {
                        $bio = app\models\hronline\Tblprcobiodata::find()->where(['!=', 'tblprcobiodata.Status', 6])
                            //  ->joinWith('jawatan')
                            ->joinWith('statusLantikan')
                            ->andWhere(['appointmentstatus.ApmtStatusCd' => 1])
                            ->andWhere(['tblprcobiodata.NatStatusCd' => 1])
                            // ->andWhere(['gredjawatan.job_category' => 1])
                            ->all();
                    } else {
                        $bio = app\models\hronline\Tblprcobiodata::find()->all();
                    }

                    echo $form->field($searchModel, 'CONm')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($bio, 'CONm', 'CONm'),
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
                <br /><br /><br />
                

                <div class="form-group">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'carian_kategorijawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ["1" => "Akademik", "2" => "Pentadbiran"],
                        'options' => ['placeholder' => 'Kategori Jawatan', 'class' => 'form-control col-md-2 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'klasifikasi_id')->label(false)->widget(Select2::classname(), [
                        'data' => $arrKlasifikasi,
                        'options' => ['placeholder' => 'Klasifikasi Perkhidmatan', 'class' => 'form-control col-md-2 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                        $form->field($searchModel, 'statLantikan')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                            'options' => ['placeholder' => 'Appointment Status', 'class' => 'form-control col-md-4 col-xs-12'],
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
                        <?= Html::a('Reset', ['search-all'], ['class' => 'btn btn-danger']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div></div>
    <?php ActiveForm::end(); ?>

    <!--<div class="x_panel" >
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">INFO</p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table class="table table-sm table-bordered jambo_table table-striped">
            <tr>
                <td style="width:30%"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                            '',
                                        ], [
                                            'class' => 'btn btn-primary',
                                            'target' => '_blank',
                                        ]); ?>
            CVonline
        </td>
        <td style="width:30%"><?= Html::a('<i class="fa fa-info-circle" aria-hidden="true"></i>', [
                                    '',
                                ], [
                                    'class' => 'btn btn-success',
                                    'target' => '_blank',
                                ]); ?>
            Laporan <b>"Telah Disahkan"</b>
        </td>
        <td><?= Html::a('<i class="fa fa-info-circle" aria-hidden="true"></i>', [
                '',
            ], [
                'class' => 'btn btn-warning',
                'target' => '_blank',
            ]); ?>
            Laporan <b>"Data Mentah"</b>
        </td> 
            </tr>
        </table>
    </div>
</div>
    -->

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:18px;font-weight: bold;">REKOD KAKITANGAN AKADEMIK DAN PENTADBIRAN</p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="table-responsive">

                <?=
                GridView::widget([
                    'options' => ['id' => 'cvs'],
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'KATEGORI',
                            'value' => function ($model) {
                                return $model->jawatan->job_category == 1 ? 'AKADEMIK' : 'PENTADBIRAN';
                            },

                        ],
                        [
                            'label' => 'NAMA',
                            'value' => function ($model) {
                                return $model->CONm;
                            }
                        ],
                        [
                            'label' => 'JAWATAN',
                            'value' => function ($model) {
                                return $model->jawatan->fname;
                            }
                        ],
                        //     [
                        //     'label' => 'JAWATAN PENTADBIRAN',
                        //     'value' => function($model) {
                        //     if( $model->adminpos->adminpos)
                        //     {
                        //         return $model->adminpos->adminpos->position_name;
                        //     }
                        //     else
                        //     {
                        //         return '-';
                        //     }
                        //     }
                        // ],
                        [
                            'label' => 'JAFPIB',
                            'value' => function ($model) {
                                return $model->department->fullname;
                            }
                        ],
                        [
                            'label' => 'STATUS LANTIKAN',
                            'value' => function ($model) {
                                return $model->statusLantikan ? $model->statusLantikan->ApmtStatusNm : '';
                            }
                        ],
                        [
                            'label' => 'STATUS',
                            'value' => function ($model) {
                                return $model->serviceStatus ? $model->serviceStatus->ServStatusNm : '';
                            }
                        ],
                        [
                            'label' => 'TINDAKAN',
                            'value' => function ($model) {

                                return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                    'view-cv',
                                    'id' => ($model->ICNO),
                                    'title' => 'personal',
                                ], [
                                    'class' => 'btn btn-primary',
                                    'target' => '_blank',
                                ]) ;
                            },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                        ],
                        //                            [
                        //                                'class' => 'yii\grid\CheckboxColumn',
                        //                                'checkboxOptions' => function ($model, $key, $index, $column) {
                        //
                        //                                    return ['value' => $model->ICNO, 'id' => $model->ICNO, 'onclick' => 'check(this.value, this.checked)'];
                        //                                }
                        //                                    ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>

    <?php
    $icno = '';
    foreach ($dataProvider->query->all() as $d) {
        $icno = $icno . ',' . $d->ICNO;
    }
    ?>
    <script>
        document.getElementsByClassName("select-on-check-all")[0].setAttribute("onclick", "selectall(this.checked)");
        var inputs = document.getElementsByTagName('input');
        var is_checked = false;
        var t = '';
        document.getElementsByClassName("select-on-check-all")[0].checked = true;
        for (var x = 0; x < inputs.length; x++) {
            if (inputs[x].type == 'checkbox' && inputs[x].name == 'selection[]') {
                is_checked = inputs[x].checked;
                if (is_checked == false) {
                    document.getElementsByClassName("select-on-check-all")[0].checked = false;
                }
            }
        }
        var data = sessionStorage.getItem('checkedcv');
        var icno = data.split(',');
        for (i = 0; i < icno.length; i++) {
            var element = document.getElementById(icno[i]);
            if (typeof(element) != 'undefined' && element != null) {
                element.checked = true;
            }
        }

        function selectall(c) {
            var icno = "<?= $icno ?>";
            var icno1 = icno.split(',');
            var data = sessionStorage.getItem('checkedcv');
            if (data == null) {
                data = '';
            }
            if (c === true) {
                for (i = 0; i < icno1.length; i++) {

                    if (data.includes(icno1[i])) {} else {
                        data = data + ',' + icno1[i];
                    }
                }
            } else {
                for (i = 0; i < icno1.length; i++) {
                    if (data.includes(icno1[i])) {
                        data = data.replace(',' + icno1[i], '');
                        data = data.replace(icno1[i], '');
                    }
                }

            }
            sessionStorage.setItem('checkedcv', data);
        }

        function check(val, c) {
            var data = sessionStorage.getItem('checkedcv');
            if (c === true) {
                data = data + ',' + val;
            } else {
                data = data.replace(',' + val, '');
                data = data.replace(val, '');
            }
            sessionStorage.setItem('checkedcv', data);
        }

        function test() {
            var gred = "<?= $request->get('id') ?>";
            var data = sessionStorage.getItem('checkedcv');
            var keys = $('#cvs').yiiGridView('getSelectedRows');
            window.open("data?gred=" + gred, '_blank');
        }
    </script>