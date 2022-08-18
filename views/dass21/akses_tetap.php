<?php


$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use yii\grid\CheckboxColumn;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?= $this->render('_navbar') ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Akses</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['action' => ['penetapan-akses'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>



                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'CONm')->textInput(['id' => 'nama_pyd'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kp_paspot">No. KP / Pasport
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'ICNO')->textInput(['id' => 'kp_paspot'])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group jspiu">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Senarai JSPIU</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'DeptId')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'fullname'),
                            'options' => [
                                'placeholder' => 'Pilih Jabatan',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                //'id' => 'senarai',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Akses</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'akses')->label(false)->widget(Select2::classname(), [
                            'data' => ['1' => 'ADA', '2' => 'TIDAK ADA'],
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Pilih Akses',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                //'id' => 'senarai',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'attribute' => 'CONm',
                                'label' => 'NAMA',
                                'headerOptions' => ['class' => 'column-title'],
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'JSPIU',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->department->shortname;
                                },
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'AKSES',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->dassAkses) ? '-' : 'ADA';
                                },
                                //'attribute' => 'test'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                //'attribute' => 'CONm',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{update}',
                                //'header' => 'TINDAKAN',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        $url = Url::to(['dass21/akses', 'ICNO' => $model->ICNO]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                </div>
                <?php
                Modal::begin([
                    'header' => '<strong>Kemaskini Akses Pegawai</strong>',
                    'id' => 'modal',
                    'size' => 'modal-lg',
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
                ?>

            </div>
        </div>
    </div>
</div>