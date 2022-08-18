<?php

use yii\grid\GridView;

$this->registerJs('
    var gridview_id = ""; // specific gridview
    var columns = [6,7]; // index column that will grouping, start 1  
    var column_data = [];
        column_start = [];
        rowspan = [];
    for (var i = 0; i < columns.length; i++) {
        column = columns[i];
        column_data[column] = "";
        column_start[column] = null;
        rowspan[column] = 1;
    }
    var row = 1;
    $(gridview_id+" table > tbody  > tr").each(function() {
        var col = 1;
        $(this).find("td").each(function(){             
            for (var i = 0; i < columns.length; i++) {
                if(col==columns[i]){
                    if(column_data[columns[i]] == $(this).html()){
                        $(this).remove();
                        rowspan[columns[i]]++;
                        $(column_start[columns[i]]).attr("rowspan",rowspan[columns[i]]);
                    }
                    else{
                        column_data[columns[i]] = $(this).html();
                        rowspan[columns[i]] = 1;
                        column_start[columns[i]] = $(this);
                    }
                }                   
            }               
            col++;
        })
        row++;
    });

    $(document).on("ready pjax:success", function(){
        var gridview_id = ""; // specific gridview
        var columns = [1]; // index column that will grouping, start 1  
        var column_data = [];
            column_start = [];
            rowspan = [];
        for (var i = 0; i < columns.length; i++) {
            column = columns[i];
            column_data[column] = "";
            column_start[column] = null;
            rowspan[column] = 1;
        }
        var row = 1;
        $(gridview_id+" table > tbody  > tr").each(function() {
            var col = 1;
            $(this).find("td").each(function(){             
                for (var i = 0; i < columns.length; i++) {
                    if(col==columns[i]){
                        if(column_data[columns[i]] == $(this).html()){
                            $(this).remove();
                            rowspan[columns[i]]++;
                            $(column_start[columns[i]]).attr("rowspan",rowspan[columns[i]]);
                        }
                        else{
                            column_data[columns[i]] = $(this).html();
                            rowspan[columns[i]] = 1;
                            column_start[columns[i]] = $(this);
                        }
                    }                   
                }               
                col++;
            })
            row++;
        });
    });
');

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-bar-chart"></i>&nbsp;IDP List <?= $lpp->tahun ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        // 'striped' => false,
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'dataProvider' => $dataProvider2,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                            ],
                            [
                                'label' => 'JENIS',
                                'headerOptions' => ['class' => 'column-title text-center'],
                                'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                'value' => function ($model) {
                                    return $model->sasaran3->kompetensii;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'LATIHAN',
                                'headerOptions' => ['class' => 'column-title text-center'],
                                'value' => function ($model) {
                                    return $model->sasaran3->tajukLatihan;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'TARIKH MULA',
                                'headerOptions' => ['class' => 'column-title text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    $date1 = new DateTime($model->tarikhMula);
                                    $date2 = new DateTime($model->tarikhAkhir);
                                    $days  = $date2->diff($date1)->format('%a');
                                    return Yii::$app->formatter->asDate($model->tarikhMula, 'dd') . ' - ' . Yii::$app->formatter->asDate($model->tarikhAkhir, 'dd/MM/yyyy') . ' (' . ($days + 1) . ' hari)';
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'LOKASI',
                                'headerOptions' => ['class' => 'column-title text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->lokasiKursus;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'MATA MINIMA CPD',
                                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) use ($mataCpd) {
                                    return !is_null($mataCpd) ? (($mataCpd->idp_mata_min == 0) ? 'Dikecualikan' : $mataCpd->idp_mata_min) : '';
                                },
                                'format' => 'html',
                                // 'group' => true
                            ],
                            [
                                'label' => 'JUMLAH MATA CPD TERKUMPUL',
                                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) use ($mataCpd, $summ) {
                                    return !is_null($mataCpd) ?  (($mataCpd->idp_mata_min == 0) ? 'Dikecualikan' : $summ) : '';
                                },
                                'format' => 'html',
                                // 'group' => true
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>