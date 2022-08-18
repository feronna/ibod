<?php

use app\models\cuti\CutiTblBod;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use app\models\kehadiran\TblYears;
use yii\widgets\LinkPager;

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
                    'action' => ['cb-list'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($searchModel, 'carian_nama')->textInput()->input('name', ['placeholder' => "Nama Kakitangan"])->label(false); ?>
                    <?php
                    echo $form->field($searchModel, 'carian_tahun')->dropDownList(
                        [ArrayHelper::map(TblYears::find()->where(['status' => 1])->orderBy(['year' => SORT_DESC])->all(), 'year', 'year')]
                        // ['prompt' => 'Choose Status...']
                    )->label(false);
                    ?>

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?php
                    echo $form->field($searchModel, 'carian_status')->dropDownList(
                        ['BSMCHECK' => 'SEMAKAN BSM', 'ENTRY' => 'ENTRY', 'AGREED' => 'AGREED', 'VERIFIED' => 'VERIFIED', 'APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED', 'RETURNED' => 'RETURNED'],
                        ['prompt' => 'Choose Status...']
                    )->label(false);
                    ?>

                </div>

                <div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right; float:right; width:50%;">

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                        <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12 ">
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

                                <th style="width: auto">UMSPER</th>
                                <th style="width: auto">Staff Name</th>
                                <th style="width: auto">Gred</th>
                                <th style="width: auto">JFPIB</th>
                                <th style="width: auto">Jenis Cuti</th>
                                <th style="width: auto">Status</th>
                                <th style="width: auto">Tarikh Bercuti</th>
                                <th style="width: auto">Tempoh</th>
                                <th style="width: auto">Surat EDD</th>
                                <th style="width: auto">Surat Akuan Bersalin</th>
                                <th style="width: auto">Sijil Lahir</th>
                                <th style="width: auto">Surat</th>
                                <th style="width: auto">Status Kembali Bertugas</th>
                                <th style="width: auto">Tindakan</th>

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

                                    <td><?= $data->kakitangan->COOldID ?></td>
                                    <td><?= $data->kakitangan->CONm ?></td>
                                    <td><?= $data->kakitangan->jawatan->gred ?></td>
                                    <td><?= $data->kakitangan->department->shortname ?></td>
                                    <td><?= $data->jenisCuti->jenis_cuti_nama ?></td>
                                    <td><?= $data->status ?></td>
                                    <td><?= $data->full_date ?></td>
                                    <td><?= $data->tempoh ?></td>
                                    <td><?= $data->displayLinks ?></td>
                                    <td><?= $data->displayLinkFile1 ?></td>
                                    <td><?= $data->displayLinkFile2 ?></td>
                                    <?php if ($data->jenis_cuti_id == 28 && $data->status == "APPROVED") { ?>
                                        <td><?php echo Html::a('<i class="fa fa-download" aria-hidden="true"></i> SURAT', [
                                                'surat',
                                                // 'title' => 'Maternity',
                                                'id' => $data->id
                                            ], [
                                                'class' => 'btn btn-default',
                                                'target' => '_blank',
                                            ]) . '<br/>'; ?></td>
                                        <td><?= CutiTblBod::status($data->id) ?></td>
                                        <td> <?= CutiTblBod::button($data->id) ? Html::a('<i class="fa fa-check-circle-o"></i> Click to Accept', Url::to(['cuti/admin/bod']), ['data-method' => 'POST', 'data-confirm' => 'Are you sure you?', 'data-params' => ['id' => $data->id], 'class' => 'btn btn-success btn-sm pull-right']) : '' ?>
                                        </td>

                                </tr>
                            <?php } else { ?>
                                <td></td>
                            <?php } ?>
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
</div>