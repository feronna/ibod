<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\Pjax;

// You only need add this, 
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
                        <?php Pjax::begin([
                            'id' => 'grid_senarai', 'timeout' => false, 'enablePushState' => false
                        ]) ?>
                        <?=
                        GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'caption' => '<p class="text-left"><sub>Klik butang <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-thumbs-down"></span> Tolak</button>untuk menolak dokumen yang telah dimuatnaik<br/>Klik butang <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> Terima</button>untuk mengesah dokumen yang telah dimuatnaik</sub></p>',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'header' => 'BULAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return ucfirst($model->monthLabel->slabel ?? '');
                                    },
                                    // 'group' => true,

                                ],
                                [
                                    'label' => 'RINGKASAN AKTIVITI / PROJEK',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return '<sup>' . Yii::$app->formatter->asDate($model->updated_dt ?? $model->created_dt, 'dd/MM/yyyy') . '</sup><br>' . $model->ringkasan;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'SASARAN KERJA',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return  $model->sasaran_kerja;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'PENCAPAIAN SEBENAR',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return $model->capai;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'DOKUMEN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return ($model->document) ? Html::a("<i class='fa fa-file' aria-hidden='true'></i>
                                        ", Url::to(['lppums/view-file', 'hashfile' => $model->document->filehash, 'lpp_id' => $model->lpp_id]), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br/><sub><b>' . (($model->document->verified_ppp) ? 'Disahkan oleh PPP' : ' ') . '</b></sub>' : '';
                                        // return $model->id;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'PENGESAHAN PPP',
                                    'visible' => $ppp,
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'template' => '{approve}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'approve' => function ($url, $model) use ($bhg, $order) {
                                            $url = Url::to(['lppums/approve-skt-ppp', 'skt_id' => $model->id, 'aspek_id' => $model->aspek_id, 'lpp_id' => $model->lpp_id, 'bhg' => $bhg, 'order' => $order]);
                                            return $model->id ?  Html::a(!($model->document->verified_ppp)  ? '<span class="glyphicon glyphicon-thumbs-up"></span> Terima' : '<span class="glyphicon glyphicon-thumbs-down"></span> Tolak', false, [
                                                'title' => 'Approve',
                                                // 'data-confirm' => 'Adakah anda pasti?',
                                                'class' =>  !($model->document->verified_ppp)  ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs',
                                                'onclick' => "
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: '" .  $url . "',

                                                                    success: function(result) {
                                                                        if(result) {
                                                                            $.pjax.reload({
                                                                                container: '#grid_senarai',
                                                                                url: 'senarai-skt?lpp_id=' + result.lpp_id + '&order=' + result.aspek_id + '&bhg=' + result.bhg,
                                                                            });
                                                                        } 
                                                                    }, 
                                                                    error: function(result) {
                                                                        console.log(\"Record not found\");
                                                                    }
                                                                });
                                                                
                                                            ",
                                            ]) : '';
                                        },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>