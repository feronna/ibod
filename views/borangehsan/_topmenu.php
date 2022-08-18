<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => [
    ['label' => ''], 
    ['label' => app\models\kemudahan\Borangehsan::totalPending(Yii::$app->user->getId()),
          'items' => [
                                            [
                                                'label' =>  app\models\kemudahan\Borangehsan::totalPending(Yii::$app->user->getId())
                                            ],
             
                                             
                                        ],],
    ['label' => app\models\kemudahan\Borangehsan::totalPending3(Yii::$app->user->getId()),
          'items' => [
                                            [
                                                'label' =>  app\models\kemudahan\Borangehsan::totalPending3(Yii::$app->user->getId())
                                            ],
             
                                             
                                        ],],
    ['label' => app\models\kemudahan\Borangehsan::totalPending2(Yii::$app->user->getId()),
          'items' => [
                                            [
                                                'label' =>  app\models\kemudahan\Borangehsan::totalPending2(Yii::$app->user->getId())
                                            ],
                                            [
                                                'label' =>  app\models\kemudahan\Borangehsan::totalPending4(Yii::$app->user->getId())
                                            ],
             
                                             
                                        ],],
     ['label' => app\models\kemudahan\Borangehsan::totalPending5(Yii::$app->user->getId()),
          'items' => [
                                            [
                                                'label' =>  app\models\kemudahan\Borangehsan::totalPending5(Yii::$app->user->getId())
                                            ],
             
                                             
                                        ],],
      
    
   
    
]]); ?>
