<div class="col-md-12 col-sm-12 col-xs-12">
    <?=
    \app\widgets\TopMenuWidget::widget(['top_menu' => [1029, 1032, 1035, 1044, 1051, 1059], 'vars' => [
            ['label' => ''],
            ['label' => app\models\w_letter\TblPermohonan::totalPendingKj(),
                'items' => [
                    [
                        'label' => app\models\w_letter\TblPermohonan::totalPendingKj()
                    ],
                ],
            ],
            ['label' => app\models\w_letter\TblPermohonan::totalPendingBsm(),
                'items' => [
                    [
                        'label' => app\models\w_letter\TblPermohonan::totalPendingBsm()
                    ],
                ],
            ],
            ['label' => app\models\w_letter\TblPermohonan::totalPendingPelulus(),
                'items' => [
                    [
                        'label' => app\models\w_letter\TblPermohonan::totalPendingPelulus()
                    ],
                ],
            ],
            ['label' => app\models\w_letter\TblPermohonan::totalPendingVc(),
                'items' => [
                    [
                        'label' => app\models\w_letter\TblPermohonan::totalPendingVc()
                    ],
                ],
            ],
            ['label' => ''],
    ]]);
    ?>  
</div>

