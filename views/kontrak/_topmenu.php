<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [8,10,12], 'vars' => [
    ['label' => ''],
    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId(),0),
        'items' => [
                                            [
                                                'label' =>app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId(), 2)
                                            ],
                                            [
                                                'label' =>app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId(), 1)
                                            ],
                                        ],],
    [
        'label' => '',
        'items' => [
                                            [
                                                'label' =>'<span style="font-size: 8px;" class="badge bg-orange">Pentadbiran</span>'
                                            ],
                                            [
                                                'label' =>'<span style="font-size: 8px;" class="badge bg-orange">Pentadbiran</span>'
                                            ],
            [
                                                'label' =>'<span style="font-size: 8px;" class="badge bg-orange">Pentadbiran</span>'
                                            ],
                                            [
                                                'label' =>'<span style="font-size: 8px;" class="badge bg-green">Akademik</span>'
                                            ],
            [
                                                'label' =>'<span style="font-size: 8px;" class="badge bg-green">Akademik</span>'
                                            ],
            [
                                                'label' =>'<span style="font-size: 8px;" class="badge bg-green">Akademik</span>'
                                            ],
                                        ],]
]]); ?>