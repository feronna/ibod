 
    <?=
    \app\widgets\TopMenuWidget::widget(['top_menu' => [1101,1121,1151,1105,1137,1140,1146,1278,1374,1379], 'vars' => [
        ['label' => ''], 
        ['label' => ''],
        ['label' => app\models\cv\TblPermohonan::TotalPending(Yii::$app->user->getId(),1),
            'items' => [
                [
                    'label' => app\models\cv\TblPermohonan::TotalPending(Yii::$app->user->getId(),1)
                ]
            ],],
        ['label' => ''],
        ['label' => ''],
        ['label' => ''],
        ['label' => ''], 
        ['label' => app\models\cv\TblPermohonan::TotalPendingDean(Yii::$app->user->getId(),1),
            'items' => [
                [
                    'label' => app\models\cv\TblPermohonan::TotalPendingDean(Yii::$app->user->getId(),1)
                ]
            ],], 
        ['label' => ''],
        ['label' => app\models\cv\TblPermohonan::TotalPendingPeraku(Yii::$app->user->getId(),1),
            'items' => [
                [
                    'label' => app\models\cv\TblPermohonan::TotalPendingPeraku(Yii::$app->user->getId(),1)
                ]
            ],],
    ]]);
    ?>   

