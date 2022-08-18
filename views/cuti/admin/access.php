<?php

use app\models\cuti\JenisCuti;
use app\models\hronline\Campus;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Kakitangan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['access'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>

                <?= $form->field($searchModel, 'akses_cuti_icno')->textInput()->input('name', ['placeholder' => "ICNO"])->label(false); ?>
                <?= $form->field($searchModel, 'carian_nama')->textInput()->input('name', ['placeholder' => "Nama Kakitangan"])->label(false); ?>
                <?=
                  $form->field($searchModel, 'akses_cuti_int')->dropDownList(
                    ['2' => 'Penyelia JFPIB', '3' => 'Admin'],
                    ['prompt' => 'Sila Pilih...']
                )->label(false);
                ?>
                <?=
                    $form->field($searchModel, 'akses_jspiu_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->where(['isActive' => '1'])->all(), 'id', 'fullname'),
                        'options' => ['placeholder' => 'Choose Department', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
                <?=
                    $form->field($searchModel, 'akses_kampus_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name'),
                        'options' => ['placeholder' => 'Choose Campus', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>


                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Admin Access</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">

                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'label' => 'Name',
                                    'value' => 'slverifier.CONm',
                                ],
                                [
                                    'label' => 'Position',
                                    'value' => 'jawatan',
                                ],
                                [
                                    'label' => 'Access',
                                    'value' => 'access',
                                ],
                                [
                                    'label' => 'JFPIB',
                                    'value' => 'department.shortname',
                                ],
                                [
                                    'label' => 'Campus',
                                    'value' => 'campus.campus_name',
                                ],
                                [
                                    'label' => 'Remove Access',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a('<i class="fa fa-trash">', ["cuti/admin/delete-access", 'id' => $data->akses_cuti_id]);
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'Edit Access',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a('<i class="fa fa-pencil">', ["cuti/admin/update-access", 'id' => $data->akses_cuti_id]);
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'Add Access',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a('<i class="fa fa-plus">', ["cuti/admin/add-access", 'id' => $data->akses_cuti_icno]);
                                    },
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],

                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>