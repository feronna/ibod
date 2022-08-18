<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [224, 227, 229, 231, 1322], 'vars' => [
    ['label' => ''],
    
    ['label' => app\models\ln\Ln::totalPending(Yii::$app->user->getId()),
          'items' => [
                        [
                            'label' => app\models\ln\Ln::totalPending(Yii::$app->user->getId())
                        ],                                          
                            ],],
    
//    ['label' => ''],
    
     ['label' => app\models\ln\Ln::totalPending2(Yii::$app->user->getId()),
          'items' => [
                        [
                            'label' => app\models\ln\Ln::totalPending2(Yii::$app->user->getId())
                        ],                                          
                            ],],
    
     ['label' => app\models\ln\Ln::totalPending3(Yii::$app->user->getId()),
          'items' => [
                        [
                            'label' => app\models\ln\Ln::totalPending3(Yii::$app->user->getId())
                        ],                                          
                            ],],
]]); ?>