<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>  

<?php
$form = ActiveForm::begin([
            'action' => ['search-bon'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]);
?> 
<div class="x_panel" >
    <div class="x_title">
        <h2>Carian</h2>
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
                        'data' => $b,
                        'options' => ['placeholder' => 'Nama'],
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
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
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
                    $form->field($searchModel, 'statLantikan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\StatusLantikan::find()->where(['ApmtStatusCd' => [1,2]])->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                        'options' => ['placeholder' => 'Status Lantikan', 'class' => 'form-control col-md-4 col-xs-12'],
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
                        'options' => ['placeholder' => 'Pendidikan Tertinggi', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($searchModel, 'Status')->label(false)->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(app\models\hronline\ServiceStatus::find()->where(['ServStatusCd'=>[1,2]]), 'ServStatusCd', 'ServStatusNm'),
                        'data' => ArrayHelper::map(\app\models\hronline\ServiceStatus::find()->where(['ServStatusCd' => [1,2]])->all(), 'ServStatusCd', 'ServStatusNm'),
                        'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
<?= Html::a('Reset', ['search-bon'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>           
    </div>
</div>
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2><strong>Rekod Bon Perkhidmatan Kakitangan - Akademik</strong></h2>
        <div class="clearfix"></div>
    </div>
    <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'NAMA',
                        'value' => function($model) {
                            return $model->CONm;
                        }
                    ],
                    [
                     'label' => 'GRED/JAWATAN',
                         'value' => function($model) {
                            return $model->jawatan->fname;
                        }
                        ],
//                    'jawatan.fname',
                    'department.fullname',
//                        ],
                    [
                        'label' => 'PERINCIAN',
                        'value' => function($model) {
                            return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                        'view-bon',
                                        'id' => sha1($model->ICNO),
//                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]) ;
                                   
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
                            ],
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => function ($model, $key, $index, $column) {

                                    return ['value' => $model->ICNO, 'id' => $model->ICNO, 'onclick' => 'check(this.value, this.checked)'];
                                }
                                    ],
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
                        if (typeof (element) != 'undefined' && element != null)
                        {
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

                if (data.includes(icno1[i])) {
                }
                else {
                    data = data + ',' + icno1[i];
                }
            }
        }
        else {
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
        }
        else {
            data = data.replace(',' + val, '');
            data = data.replace(val, '');
        }
        sessionStorage.setItem('checkedcv', data);
    }

    function test() {
        var data = sessionStorage.getItem('checkedcv');
        var keys = $('#w5').yiiGridView('getSelectedRows');
        window.open("data", '_blank');
    }

</script>
