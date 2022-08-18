<?php

use yii\helpers\Html;
use app\models\lppums\v2\RefMonths;

$months = RefMonths::find()->indexBy('month')->asArray()->all();

$aktiviti = \app\models\myidp\SiriLatihan::find()
    ->select(['c.`month`, `hrd`.`idp_SiriLatihan`.*'])
    ->joinWith('sasaran5.sasaran55')
    ->rightJoin(['c' => '`hrm`.`lppums_v2_ref_months`'], '`c`.`month` =  MONTH(`hrd`.`idp_SiriLatihan`.`tarikhMula`)')
    ->where(['idp_kehadiran.staffID' => $lpp->pyd->ICNO])
    ->andWhere(['idp_kehadiran.kategoriKursusID' => [1]])
    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $lpp->tahun])
    ->orderBy(['c.`month`' => SORT_ASC]);

$dataProvider2 = new yii\data\ArrayDataProvider([
    // 'query' => $aktiviti,
    // 'pagination' => false,
    // 'sort' => [
    //     'defaultOrder' => ['tarikhMula' => SORT_ASC],
    // ],
    'allModels' => $aktiviti->all(),
]);

$this->registerJs('
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
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= Html::encode($title) ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?=
                        \yii\grid\GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider2,
                            'columns' => [
                                [
                                    'header' => 'BULAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) use ($months) {
                                        return ucfirst($months[intval(date('m', strtotime($model->tarikhMula)))]['slabel']);
                                    },

                                ],
                                [
                                    'label' => 'RINGKASAN AKTIVITI / PROJEK',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                    // 'value' => function ($model) {
                                    //     return '<sup>' . Yii::$app->formatter->asDate($model->updated_dt ?? $model->created_dt, 'dd/MM/yyyy') . '</sup><br>' . $model->ringkasan;
                                    // },
                                    'value' => function ($model) {
                                        return $model->sasaran3->tajukLatihan;
                                    },
                                    'format' => 'html',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>