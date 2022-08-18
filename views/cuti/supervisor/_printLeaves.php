<?php
use yii\helpers\Html;
use yii\grid\GridView;
Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');


?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
                                    'value' => 'id',
                                ],
                                [
                                    'label' => 'Name',
                                    'value' => 'kakitangan.CONm',
                                ],
                                [
                                    'label' => 'Position',
                                    'value' => 'kakitangan.jawatan.gred',
                                ],
                                [
                                    'label' => 'JSPIU',
                                    'value' => 'kakitangan.department.shortname',
                                ],
                                [
                                    'label' => 'JFPIB',
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
                               

                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>