<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [114, 116, 122, 1461], 'vars' => [
    ['label' => ''],
    ['label' => ''],
    ['label' => app\models\pengesahan\Pengesahan::totalPending(Yii::$app->user->getId(),0),
          'items' => [
                                            [
                                                'label' =>  app\models\pengesahan\Pengesahan::totalPending(Yii::$app->user->getId(), 1)
                                            ],
                                            [
                                                'label' =>  app\models\pengesahan\Pengesahan::totalPending(Yii::$app->user->getId(), 2)
                                            ],
                                        ],]
]]); ?>