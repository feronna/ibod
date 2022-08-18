<?php
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <h4>Sahsiah</h4>
        </li>
    </ol>
</nav>

<div class="table-responsive">
    <?=
    \kartik\grid\GridView::widget([
        'rowOptions' => ['style' => 'vertical-align:middle'],
        'id' => 'data_sahsiah',
        'emptyText' => 'Tiada Rekod',
        'striped' => false,
        'summary' => '',
        'dataProvider' => $dataProvider,
        'showFooter' => false,
        'toolbar' => [
            // [
            //     'content' => Html::button('Tambah Data', [
            //         'value' => Url::to(['elnpt3/create-pnp', 'lppid' => $lpp->lpp_id]),
            //         // 'type' => 'button',
            //         'title' => 'Tambah Data',
            //         'class' => 'btn-primary btn-sm modalButtonn'
            //     ]),
            // ],
        ],
        'panel' => [
            'after' => '<dl class="dl-horizontal">
                <dt>Late In</dt>
                <dd>' . $late . ' day(s)</dd>
                <dt>Absent</dt>
                <dd>' . $absent . ' day(s)</dd>
                <dt></dt>
                <dd><i>*Taken from STARS Attendance Report</i></dd>
            </dl>',
            // 'heading' => '<i class="fas fa-book"></i>  Library',
            'type' => 'primary',
            'before' => '<div style="padding-top: 7px;"><em>* Makluman:
                Kakitangan atau PYD yang percaya PEER telah melakukan penilaian yang tidak adil, boleh mengemukakan permohonan untuk menukar PEER kepada Ketua Pentadbiran di F/A/P/I masing-masing. Sekiranya PEER telah memberikan penilaian sahsiah yang terlalu rendah tanpa justifikasi yang jelas, maka penilaian semula hendaklah dibuat terhadap PYD.</em></div>',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'BIL',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'header' => 'KATEGORI KUALITI',
                'headerOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return '<strong>' . $model->aspek . '</strong><br/>' . $model->desc;
                }, // configure even group cell css class
                'format' => 'html',
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'PPP <sub>/ 100%</sub>',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'markah_ppp',
                'value' => function ($model) use ($lpp) {
                    return (($lpp->PPP == Yii::$app->user->identity->ICNO) || ($lpp->PPK == Yii::$app->user->identity->ICNO)) ? $model->markah_ppp : 'PPP';
                },
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Markah PPP',
                        'name' => 'markah_ppp',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model->markah_ppp,
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-sahsiah?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                        // 'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                'readonly' => ($lpp->PPP != Yii::$app->user->identity->ICNO),
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'PPK <sub>/ 100%</sub>',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'markah_ppk',
                'value' => function ($model) use ($lpp) {
                    return ($lpp->PPK == Yii::$app->user->identity->ICNO) ? $model->markah_ppk : 'PPK';
                },
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Markah PPK',
                        'name' => 'markah_ppk',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_RIGHT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model->markah_ppk,
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-sahsiah?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                        // 'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                'readonly' => ($lpp->PPK != Yii::$app->user->identity->ICNO),
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'PEER <sub>/ 100%</sub>',
                'headerOptions' => ['class' => 'text-center col-md-1'],
                'contentOptions' => ['class' => 'text-center'],
                'attribute' => 'markah_peer',
                'value' => function ($model) use ($lpp) {
                    return ($lpp->PEER == Yii::$app->user->identity->ICNO) ? $model->markah_peer : 'PEER';
                },
                'editableOptions' => function ($model, $key, $index) use ($lpp, $semester) {
                    return [
                        'header' => 'Markah PEER',
                        'name' => 'markah_peer',
                        'inputType' => kartik\editable\Editable::INPUT_TEXT,
                        'placement'     => kartik\popover\PopoverX::ALIGN_LEFT_TOP,
                        'buttonsTemplate' => '{submit}',
                        'value' => $model->markah_peer,
                        // 'displayValue' => $index,
                        'options' => [ // your widget settings here
                            'class' => 'form-control',
                            // 'id' => $index . '-syarahan',
                            // 'data' => $semester,
                            // 'pluginOptions' => [
                            //     'dropdownParent' => '#' . $index . '-syarahan-popover',
                            // ],

                        ],
                        'formOptions' => [
                            'action' => ['elnpt3/update-sahsiah?lppid=' . $lpp->lpp_id],
                        ],
                        'type' => 'primary',
                        // 'beforeInput' => '<label>Jam F2F untuk 14 minggu</label>',
                    ];
                },
                'readonly' => ($lpp->PEER != Yii::$app->user->identity->ICNO),
            ],
        ]
    ]);
    ?>

</div>