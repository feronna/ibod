<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use yii\db\Expression;

$tmp = 'reset-borang-lpp';
//$title = 'Carian borang LPP untuk direset';
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Pengguna</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">IC/KP</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                                // 'data' => ArrayHelper::map(Tblprcobiodata::find()
                                //          ->select(new Expression('CONCAT(CONm, \' - \', ICNO) as CONm, ICNO'))
                                //         ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'data' => ['0' => 'TIADA', '1' => 'ADA'],
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian Nama',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    //'id' => 'senarai',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Notifikasi</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/buka-borang']), 'class' => 'btn btn-success btn-sm modalButton']) ?>
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
                                        'label' => 'IC/KP',
                                        'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => 'icno',
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'NAMA PENGGUNA',

                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'col-md-4'],

                                        'value' => 'name',
                                    ],
                                    [
                                        'label' => 'TINDAKAN',
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center col-md-2'],
                                        'value' => function ($model) {
                                            //                                        $url = Url::to(['lppums/kemaskini-buka-borang', 'id' => $model->id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => Url::to(['noti-info', 'id' => $model->id]), 'class' => 'btn btn-default btn-sm modalButton']) .
                                                Html::a('<span class="glyphicon glyphicon-trash"></span>', ['lppums/padam-buka-borang', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                        },
                                        'format' => 'raw',
                                    ]
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => 'Noti Info',
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>