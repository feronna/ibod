<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchBorang', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Hasil Carian</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <?php
                Modal::begin([
                    'header' => 'Reset Borang',
                    'id' => 'modal',
                    'size' => 'modal-md',
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
            ?>
            <div class="table-responsive">
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'pager' => [
                                'class' => \kop\y2sp\ScrollPager::className(),
                                'container' => '.grid-view tbody',
                                'triggerOffset' => 10,
                                'item' => 'tr',
                                'paginationSelector' => '.grid-view .pagination',
                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                            ],
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                               
                              [
                                    'label' => 'NO. KAD PENGENALAN',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->icno;
                                    },
                                    'format' => 'html',
                                ],          
                                
                                [
                                    'label' => 'NAMA PEMOHON',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->icno) ? '<font color="maroon"><i>(not set)</i></font>' : $model->kakitangan->CONm;
                                    },
                                    'format' => 'html',
                                ],
                                   
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'header' => 'TINDAKAN',
//                                    'headerOptions' => ['class'=>'text-center col-md-2'],
//                                    'contentOptions' => ['class'=>'text-center'],
//                                    'template' => '{reset}',
//                                    'buttons' => [
//                                        'reset' => function ($url, $model) {
//                                            $url = Url::to(['elnpt/reset', 'lpp_id' => $model->lpp_id]);
//                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
//
//                                        },
//                                    ],
//                                ],            
                            ],
                        ]);
                    ?>
                </div>
        </div>
    </div>
    </div>
</div>       