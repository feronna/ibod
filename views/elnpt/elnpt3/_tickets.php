<?php
$this->registerJs('');

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->registerJs("
    $('.modalButtonTicket').on('click', function () {
        $('#modalTicket').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $('#modalTicket').on('hidden.bs.modal', function () {
        $.pjax.reload({
            container: '#list_ticket',
            url: 'pjax-tickets?lppid=" . $lpp->lpp_id . "',
        });
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButtonTicket').on('click', function () {
            $('#modalTicket').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    });

    $('.modalButtonContent').on('click', function () {
        $('#modalTicketCont').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $(document).on('ready pjax:success', function() {
        $('.modalButtonContent').on('click', function () {
            $('#modalTicketCont').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
        });
    });
");

?>

<?php
Modal::begin([
    'header' => '<strong>Create Support Ticket</strong>',
    'id' => 'modalTicket',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
        'tabindex' => false,
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<strong>View Ticket Contents</strong>',
    'id' => 'modalTicketCont',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Cadangan & Aduan</h4>
        </li>
    </ol>
</nav>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'rowOptions' => ['style' => 'vertical-align:middle'],
        'id' => 'list_ticket',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'pjax_tickets',
            ],
        ],
        'showFooter' => false,
        'toolbar' => [
            [
                'content' => Html::button('Open a New Ticket', [
                    'value' => Url::to(['elnpt3/add-support-ticket', 'lppid' => $lpp->lpp_id]),
                    // 'type' => 'button',
                    'title' => 'Create Support Ticket',
                    'class' => 'btn btn-primary btn-sm modalButtonTicket'
                ]),
            ],
        ],
        'panel' => [
            'after' =>  '<div style="padding-top: 7px;">
                <dl class="dl-horizontal">
                    <dt><span class="label label-primary">OPEN</span></dt>
                    <dd>We’ve received your response and are continuing to work on your ticket.</dd>
                    <dt><span class="label label-warning">WAITING</span></dt>
                    <dd>The assigned agent has reviewed your ticket, contacted you for more information, and is now waiting for your response.</dd>
                    <dt><span class="label label-success">CLOSED</span></dt>
                    <dd>Your issue is resolved and the ticket requires no further action.</dd>
                </dl>
            </div>',
            // 'heading' => '<i class="fas fa-book"></i>  Library',
            'type' => 'primary',
            'before' => '<div style="padding-top: 7px;"><p><strong>Welcome to the Support Center</strong></p><br/>In order to streamline support requests and better serve you, we utilize a support ticket system. Every support request is assigned a unique ticket number which you can use to track the progress and responses online. For your reference we provide complete archives and history of all your support requests.</div>',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'label' => 'SUBJECT',
                'headerOptions' => ['class' => 'column-title text-center'],
                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                    return $model->title;
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
                'label' => 'STATUS',
                'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model, $key, $index) use ($form, $inputs, $lpp) {
                    return $model->ticketStatus();
                },
                'format' => 'raw',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'RESPONSES',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) use ($lpp) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', [
                            'value' => Url::to(['elnpt3/my-contents-by-ticket',  'lppid' => $lpp->lpp_id, 'ticket_id' => $model->id]),
                            // 'type' => 'button',
                            'title' => 'View Ticket',
                            'class' => 'btn btn-xs btn-default modalButtonContent'
                        ]);
                    },
                ],
            ],
        ]
    ]);
    ?>
</div>