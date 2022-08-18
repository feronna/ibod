<hr />

<div class="col-md-5">
    <?=
    \kartik\detail\DetailView::widget([
        'model' => $miniSummary,
        'labelColOptions' => ['style' => 'width: 50%'],
        'attributes' => [
            [
                'group' => true,
                'label' => '',
                'rowOptions' => ['class' => 'table-info']
            ],
            [
                'label' => 'MATA SASARAN SETAHUN',
                'value' => '<strong>' . $miniSummary['sasaranSetahun'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],
            // [
            //     'label' => 'MATA SASARAN SETAHUN',
            //     'value' => '<strong>' . $miniSummary['jumlahHakiki'] . '</strong>',
            //     'valueColOptions' => ['class' => 'text-center'],
            //     'format' => 'raw',
            // ],

            [
                'label' => 'SASARAN MATA HAKIKI (70%)',
                'value' => '<strong>' . $miniSummary['sasaranHakiki'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],
            [
                'label' => 'SASARAN MATA SELAIN HAKIKI (30%)',
                'value' => '<strong>' . $miniSummary['sasaranNonHakiki'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],

            [
                'group' => true,
                'label' => '',
                'rowOptions' => ['class' => 'table-info'],
                'format' => 'raw',
            ],

            [
                'label' => 'MATA HAKIKI YANG DIAMBILKIRA',
                'value' => '<strong>' . $miniSummary['mataHakiki'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],

            [
                'label' => 'MATA SELAIN HAKIKI YANG DIAMBILKIRA',
                'value' => '<strong>' . $miniSummary['mataNonHakiki'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],

            [
                'label' => 'LIMPAHAN HAKIKI KE SELAIN HAKIKI',
                'value' => '<strong>' . $miniSummary['limpahanHakiki'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],

            [
                'group' => true,
                'label' => '',
                'rowOptions' => ['class' => 'table-info'],
                'format' => 'raw',
            ],

            [
                'label' => 'PERATUS MARKAH',
                'value' => '<strong>' .  $miniSummary['peratus'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],
            [
                'label' => 'PERATUS MARKAH BERPEMBERAT',
                'value' => '<strong>' . $miniSummary['peratusPemberat'] . '</strong>',
                'valueColOptions' => ['class' => 'text-center'],
                'format' => 'raw',
            ],
        ]
    ])
    ?>
</div>