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
                <h2><strong>List</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

            <span class="badge" style="background-color :pink"><u><?= Html::a('[Add New]', ["cuti/admin/add-behalf-action"]) ?>
                    </u></span>
                <div class="table-responsive">

                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'label' => 'Officer',
                                    'value' => 'officer.CONm',
                                ],
                                [
                                    'label' => 'Executive',
                                    'value' => 'executive.CONm',
                                ],
                                [
                                    'label' => 'Status',
                                    'value' => 'status',
                                ],
                                [
                                    'label' => 'Created Date',
                                    'value' => 'create_datetime',
                                ],
                               
                                [
                                    'label' => 'Remove Access',
                                    'format' => 'raw',
                                    'value' => function ($data) {
                                        return Html::a('<i class="fa fa-trash"></i>', ["cuti/admin/delete-action", 'id' => $data->id]).' | '. Html::a('<i class="fa fa-pencil">', ["cuti/admin/update-action", 'id' => $data->id]);
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