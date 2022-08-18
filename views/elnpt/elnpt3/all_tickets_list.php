<?php

$this->registerJs("
    $('.modalButtonTckt').on('click', function () {
        $('#modalttt').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $('.modalButtonTcktCont').on('click', function () {
        $('#modalTcktCont').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $('#modalttt').on('hidden.bs.modal', function () {
        $.pjax.reload({
            container: '#pjax_all_tickets',
            url: 'pjax-ticket-list',
        });
    });

    $('#modalTcktCont').on('hidden.bs.modal', function () {
        $.pjax.reload({
            container: '#pjax_all_tickets',
            url: 'pjax-ticket-list',
        });
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButtonTckt').on('click', function () {
            $('#modalttt').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    
        $('.modalButtonTcktCont').on('click', function () {
            $('#modalTcktCont').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    });
");

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\db\Expression;
use yii\widgets\Pjax;

use app\models\lppums\TblLppTahun;
use app\models\hronline\GredJawatan;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;

Modal::begin([
    'header' => '<strong>View Ticket</strong>',
    'id' => 'modalttt',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
        'tabindex' => false,
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();

Modal::begin([
    'header' => '<strong>View Ticket Content</strong>',
    'id' => 'modalTcktCont',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
        'tabindex' => false,
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('//elnpt/_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Ticket</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin() ?>
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => false], 'action' => ['elnpt3/ticket-list']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">PYD</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'ICNO')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                'id' => 'pyd',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">CATEGORY</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'category_id')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                1 => 'Bug',
                                2 => 'Feature Request',
                                3 => 'General',
                                4 => 'How To',
                                5 => 'Technical Issue',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                'id' => 'category',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'status')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                0 => 'Open',
                                10 => 'Waiting',
                                100 => 'Close',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                'id' => 'status',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">PRIORITY</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'priority')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                0 => 'LOW',
                                10 => 'MIDDLE',
                                100 => 'HIGH',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                'id' => 'priority',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
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
                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Senarai Ticket</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?=
                    \kartik\grid\GridView::widget([
                        'rowOptions' => ['style' => 'vertical-align:middle'],
                        'id' => 'list_ticket_admin',
                        'emptyText' => 'Tiada Rekod',
                        'striped' => false,
                        'summary' => '',
                        'dataProvider' => $dataProvider,
                        'pjax' => true,
                        'pjaxSettings' => [
                            'options' => [
                                'id' => 'pjax_all_tickets',
                            ],
                        ],
                        'showFooter' => false,
                        'toolbar' => [
                            [
                                // 'content' => Html::button('Create Support Ticket', [
                                //     'value' => Url::to(['elnpt3/add-support-ticket', 'lppid' => $lpp->lpp_id]),
                                //     // 'type' => 'button',
                                //     'title' => 'Create Support Ticket',
                                //     'class' => 'btn btn-primary btn-sm modalButtonTckt'
                                // ]),
                            ],
                        ],
                        'panel' => [
                            'after' =>  '<div style="padding-top: 7px;">
                                <dl class="dl-horizontal">
                                    <dt><span class="label label-primary">OPEN</span></dt>
                                    <dd>Cadangan atau aduan daripada PYD</dd>
                                    <dt><span class="label label-warning">WAITING</span></dt>
                                    <dd>Cadangan atau aduan telah dijawab, dan sekarang menunggu respon daripada PYD</dd>
                                    <dt><span class="label label-success">CLOSED</span></dt>
                                    <dd>Cadangan atau aduan selesai</dd>
                                </dl>
                            </div>',
                            // 'after' =>  '<div class="float-right float-end pull-right">' . Html::submitButton('Calculate', ['class' => 'btn btn-primary']) . '</div><div class="clearfix"></div>',
                            // 'heading' => '<i class="fas fa-book"></i>  Library',
                            'type' => 'primary',
                            'before' => '<div style="padding-top: 7px;">
                                <dl class="dl-horizontal">
                                    <dt><span class="label label-primary">OPEN</span></dt>
                                    <dd>' . $totalOpen . '</dd>
                                    <dt><span class="label label-warning">WAITING</span></dt>
                                    <dd>' . $totalWaiting . '</dd>
                                    <dt><span class="label label-success">CLOSED</span></dt>
                                    <dd>' . $totalClose . '</dd>
                                </dl>
                            </div>',
                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'ID BORANG',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    $url =  Url::to(['elnpt3/borang', 'lppid' => $model->lpp_id]);
                                    return yii\helpers\Html::a('<u><strong>' . $model->lpp_id  . '</strong></u>', $url, ['data-pjax' => 0, 'target' => '_blank']);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'PYD',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    return $model->borang->guru->CONm;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'TAHUN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    return $model->borang->tahun;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'CATEGORY',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    return $model->ticketCategory();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'STATUS',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    return $model->ticketStatus();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'PRIORITY',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    return $model->ticketPriority();
                                },
                                'format' => 'raw',
                            ],
                            [
                                'label' => 'CREATED AT',
                                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                                    return $model->created_at;
                                },
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'VIEW TICKET',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [
                                            'value' => Url::to(['elnpt3/view-ticket-admin',  'lppid' => $model->lpp_id, 'ticket_id' => $model->id]),
                                            // 'type' => 'button',
                                            'title' => 'View Ticket',
                                            'class' => 'btn btn-xs btn-default modalButtonTckt'
                                        ]);
                                    },
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'VIEW RESPONSE',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function ($url, $model, $key) {
                                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [
                                            'value' => Url::to(['elnpt3/view-ticket-content-admin',  'lppid' => $model->lpp_id, 'ticket_id' => $model->id]),
                                            // 'type' => 'button',
                                            'title' => 'View Ticket Content',
                                            'class' => 'btn btn-xs btn-default modalButtonTcktCont'
                                        ]);
                                    },
                                ],
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>