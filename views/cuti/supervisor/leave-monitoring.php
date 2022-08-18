<?php

use app\models\cuti\JenisCuti;
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
                <h2><strong>Carian / <i> Searching </i></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['leave-monitoring'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>


                <div class="form-group">

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($searchModel, 'icno')->textInput(['placeholder' => 'ICNO'])->label(false) ?>

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($searchModel, 'carian_nama')->textInput(['placeholder' => 'Nama '])->label(false) ?>

                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($searchModel, 'carian_department')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                                'options' => ['placeholder' => 'JFPIB', 'class' => 'form-control col-md-4 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <?php $searchModel->jenis_cuti_id = $jenis_cuti_id; ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($searchModel, 'jenis_cuti_id')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all(), 'jenis_cuti_id', 'jenis_cuti_catatan'),
                                'options' => ['placeholder' => 'Choose leave type', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label"><i class="fa fa-calendar"></i>&nbsp;Tarikh Bercuti / <i><?php echo Html::activeLabel($searchModel, 'full_date'); ?></i>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Bercuti start_date to end_date"></i>
                    </label>

                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php
                        $addon = '
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>';

                        echo '<div class="input-group drp-container">';
                        echo DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'full_date',
                            'useWithAddon' => true,
                            'convertFormat' => true,
                            'startAttribute' => 'start_date',
                            'endAttribute' => 'end_date',
                            'readonly' => true,
                            'pluginOptions' => [
                                'showDropdowns' => true,

                                'locale' => [
                                    'format' => 'd/m/Y',
                                    'separator' => ' to ',
                                ],
                                'opens' => 'right',

                            ]
                        ]) . $addon;
                        echo '</div>';
                        ?>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        echo $form->field($searchModel, 'carian_status')->dropDownList(
                            ['ENTRY' => 'ENTRY', 'AGREED' => 'AGREED', 'VERIFIED' => 'VERIFIED', 'APPROVED' => 'APPROVED','CHECKED' =>'CHECKED/DITERIMA' ,'REJECTED' => 'REJECTED', 'RETURNED' => 'RETURNED'],
                            ['prompt' => 'CHOOSE STATUS...']
                            // ENTRY,AGREED,CHECKED,VERIFIED,APPROVED,REJECTED,RETURNED
                        )->label(false);
                        ?>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                        <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                    </div>
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
                <h2><strong>Senarai Kakitangan Seliaan / <i> Staff List </i></strong></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <font><u><strong>RUJUKAN /<i> REFERENCE</i></u> </strong></font><br><br>

                <span class="label label-default">ENTRY</span> : Permohonan Baru / <i>New Leave Application</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                <span class="label label-primary">AGREED</span> : Pengganti Bersetuju / <i>Substitute Has Agreed</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                <span class="label label-info">VERIFIED</span> : Permohonan Cuti Diperaku / <i>Leave Application Has Been Verified</i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                <span class="label label-success">APPROVED</span> : Permohonan Cuti Diluluskan / <i> Leave Application Has Been Approved</i>

                <br>
                <br>
                <div class="table-responsive">

                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // [
                                //     'label' => 'Name',
                                //     'value' => 'id',
                                // ],
                                [
                                    'label' => 'Name',
                                    'value' => 'kakitangan.CONm',
                                ],
                                [
                                    'label' => 'Position',
                                    'value' => 'kakitangan.jawatan.gred',
                                ],
                                [
                                    'label' => 'JFPIB',
                                    'value' => 'kakitangan.department.shortname',
                                ],
                                [
                                    'label' => 'Leave Type',
                                    'value' => 'jenisCuti.jenis_cuti_nama',
                                ],
                                [
                                    'label' => 'Leave Start',
                                    'value' => function ($model, $key, $index, $widget) {
                                        return date("d-m-Y", strtotime($model->start_date));
                                    },
                                ],
                                [
                                    'label' => 'Leave End',
                                    'value' => function ($model, $key, $index, $widget) {
                                        return date("d-m-Y", strtotime($model->end_date));
                                    },
                                ],
                                [
                                    'label' => 'Duration(Day)',
                                    'value' => 'tempoh',
                                ],
                                [
                                    'label' => 'Status',
                                    'value' => 'status',
                                ],
                                [
                                    'label' => 'Check',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['leave-details', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
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