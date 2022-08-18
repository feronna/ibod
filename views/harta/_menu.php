
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [140, 144, 146, 152, 1472], 'vars' => [
       
    
          ['label' => ''],
    
         ['label' => app\models\harta\TblHarta::totalPendingKj(Yii::$app->user->getId()),
        'items' => [                       
                                            [
                                                'label' => app\models\harta\TblHarta::totalPendingKj(Yii::$app->user->getId())
                                            ],
                                          
                                        ],],
     ['label' => app\models\ptb\Recommendation::totalPendingPelulus(Yii::$app->user->getId()),
        'items' => [                        
                                            ['label' => ''],
                                            ['label' => ''],
                                            ['label' => ''],
                                            ['label' => ''],
                                            ['label' => ''],
                                        ],],
       ['label' => ''],
   

]]); ?>