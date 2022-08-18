<?php

use app\models\cuti\AksesPengguna;
use app\models\cuti\GcrApplication;
use app\models\cuti\Layak;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use yii\widgets\LinkPager;
use app\widgets\TopMenuWidget;
use yii\helpers\Url;;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Peribadi';
?>

<div class="tblprcobiodata-form">

    <?php $form = ActiveForm::begin([
        'action' => ['supervised-staff'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>

    <div class="x_panel" style="background-color:#b4c4d4;color:#37393b;">
        <div class="x_title">
            <h2>Carian / <i>Searching</i></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group ">
                <div class="form-group">
                    <div class=" col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($carian, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                                'data' => ["0" => "Nama", "1" => "IC", "2" => "UMSPER"],
                                'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                    <div class=" col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($carian, 'carian_data')->textInput(['placeholder' => 'Nama / Nombor IC / ID'])->label(false) ?>
                    </div>


                    <div class="form-group">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <?=
                                $form->field($carian, 'carian_department')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Department::find()->all(), 'id', 'fullname'),
                                    'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <?=
                                $form->field($carian, 'carian_statuslantikan')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                                    'options' => ['placeholder' => 'Status Lantikan', 'class' => 'form-control col-md-4 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?=
                                $form->field($carian, 'carian_status')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                                    'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?=
                                $form->field($carian, 'carian_gred')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(GredJawatan::find()->where(['isActive'=>'1'])->all(), 'id', 'fname'),
                                    'options' => ['placeholder' => 'Gred', 'class' => 'form-control col-md-4 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                        <div class=" col-md-3 col-sm-3 col-xs-12">
                            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<!-- <div class="col-md-12 col-sm-12 col-xs-12 "> -->
    <div class="x_panel">
        <div class="x_title" style="color:#37393b;">
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style="width:auto">Bil</th>
                                <th style="width:10px">Status Penghantaran & Permohonan GCR & CBTH (<?= date('Y') ?>)</th>
                                <th style="width: auto">UMSPER</th>
                                <th style="width: auto">Staff Name</th>
                                <th style="width: auto">Gred</th>
                                <th style="width: auto">JFPIB</th>
                                <th style="width: auto">Entitlement Date</th>
                                <th style="width: auto">Entitlement Total</th>
                                <th style="width: auto">Leave Balance</th>
                                <th style="width: auto">Entitlement</th>
                                <th style="width: auto">Leave Applications</th>
                                <th style="width: auto">Statement</th>
                                <th style="width: auto">PP</th>
                                <th style="width: auto">Back On Duty</th>
                                <th style="width: auto">Access</th>
                                <!--                                <th style="width: auto">Pendidikan Tertinggi</th>-->
                                <!--<th class="text-center" style="width:auto">Tindakan</th>-->
                            </tr>
                        </thead>
                        <!--A-->

                        <?php
                        if (!empty($model)) {

                            foreach ($model->getModels() as $data) {

                        ?>
                                <tr>
                                    <td><?php if (Yii::$app->getRequest()->getQueryParam('page') > 1) {
                                            echo (Yii::$app->getRequest()->getQueryParam('page') - 1) * 20 + $bil++;
                                        } else {
                                            echo $bil++;
                                        } ?></td>
                                    <td><?= GcrApplication::getStatus($data->ICNO).'(' .GcrApplication::getStatuss($data->ICNO).')' ?></td>
                                    <td><?= $data->COOldID ?></td>
                                    <td><?= $data->CONm ?></td>
                                    <td><?= $data->jawatan->gred ?></td>
                                    <td><?= $data->displayDepartment ?></td>
                                    <td><?= Layak::getLatestLayak($data->ICNO)->layak_mula ?></td>
                                    <td><?= Layak::getLatestLayak($data->ICNO)->layak_cuti + Layak::getLatestLayak($data->ICNO)->layak_bawa_lepas ?></td>
                                    <td><?= Layak::getBakiLatest($data->ICNO) ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-calendar-check-o">', ["cuti/supervisor/set-leave", 'id' => $data->ICNO]); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-calendar-plus-o">', ["cuti/supervisor/leave-list-sv", 'id' => $data->ICNO]); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-file">', ["cuti/supervisor/leave-statement", 'id' => $data->ICNO]); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-wrench">', ["cuti/supervisor/update-pp", 'id' => $data->ICNO]); ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-id-card">', ["cuti/supervisor/back-on-duty", 'id' => $data->ICNO]); ?></td>
                                    <td class="text-center"><?= AksesPengguna::admin($data->ICNO) ?></td>

                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="9">No Data.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
            echo LinkPager::widget([
                'pagination' => $model->pagination,

            ]);
            ?>
        </div>
    </div>
<!-- </div> -->