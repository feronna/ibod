<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use app\models\kehadiran\TblYears;
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
                    'action' => ['list'],
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
                        [ArrayHelper::map(TblYears::find()->where(['status' => 1])->orderBy(['year'=> SORT_DESC])->all(), 'year', 'year')]
                        // ['prompt' => 'Choose Status...']
                    )->label(false);
                    ?>
                   
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">

                <?php
                    echo $form->field($searchModel, 'carian_status')->dropDownList(
                        ['ENTRY' => 'ENTRY', 'AGREED' => 'AGREED', 'VERIFIED' => 'VERIFIED', 'APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED', 'RETURNED' => 'RETURNED'],
                        ['prompt' => 'Choose Status...']
                    )->label(false);
                    ?>

                    <?php
                    echo $form->field($searchModel, 'carian_bulan')->dropDownList(
                        ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember']
                        ,['prompt' => 'Choose Month...']
                    )->label(false);

                    ?>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right; float:right; width:50%;">

                <div class="form-group" >
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Kakitangan Seliaan</strong></h2>
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
                                'label' => 'Leave Date',
                                'value' => 'full_date',
                            ],
                            [
                                'label' => 'Leave Type',
                                'value' => 'jenisCuti.jenis_cuti_nama',
                            ],
                            [
                                'label' => 'Remark',
                                'value' => 'remark',
                            ],
                            [
                                'label' => 'Status',
                                'value' => 'status',
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>