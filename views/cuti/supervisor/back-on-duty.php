<?php

use app\models\cuti\CutiTblBod;
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
                <h2><strong>Senarai Cuti / <i> Staff Leave </i></strong></h2>
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
                                    'label' => 'Check',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        $val = CutiTblBod::buttons($data->id);
                                        return $val ? Html::button('', ['id' => 'modalButton', 'value' => Url::to(['bod', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']) : 'Sila Maklumkan Dengan kakitangan untuk memuat naik dokumen-dokumen yang diperlukan';
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