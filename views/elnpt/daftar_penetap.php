<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
    
?>

<?= $this->render('_menuAdmin'); ?>

<?php
    Modal::begin([
        'header' => 'Pendaftaran Penilai Penetap',
        //'id' => 'modal',
        'size' => 'modal-md',
        'options' => [
            'id' => 'modal',
            'tabindex' => false // important for Select2 to work properly
        ],
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pendaftaran Penetap Penilai bagi Tahun  <?= $tahun ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
//                            'pager' => [
//                                'class' => \kop\y2sp\ScrollPager::className(),
//                                'container' => '.grid-view tbody',
//                                'triggerOffset' => 10,
//                                'item' => 'tr',
//                                'paginationSelector' => '.grid-view .pagination',
//                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
//                             ],
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'attribute' => 'fullname',
                                    'label' => 'J/S/P/I/U',
                                    'headerOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'attribute' => 'CONm',
                                    'label' => 'PENETAP PENILAI',
                                    'headerOptions' => ['class'=>'text-center col-md-3'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'attribute' => 'tahun',
                                    'label' => 'TAHUN',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function ($data) use ($tahun){
                                        $url1 = Url::to(['elnpt/kemaskini-penetap-penilai', 'dept_id' => $data["dept_id"], 'tahun' => $tahun, 'id' => $data["id"]]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']).
                                                (is_null($data["id"]) ? '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                                                        ['/elnpt/remove-penetap-penilai', 'id' => $data["id"], 'tahun' => $tahun], ['class' => 'btn btn-default btn-sm']) );
                                         
                                    },
                                    'format' => 'raw'
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>