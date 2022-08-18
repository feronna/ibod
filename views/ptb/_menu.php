
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [11,25,27,34,42, 53, 125,126,127,128,134], 'vars' => [
       
    
        ['label' => app\models\ptb\TblTugas::totalPendingIndividu(Yii::$app->user->getId()),
        'items' => [                       ['label' => ''],
                                            [
                                                'label' =>''],
                                            
                                             [
                                                'label' => ''],
                                            
                                            [
                                                'label' => app\models\ptb\TblTugas::totalPendingIndividu(Yii::$app->user->getId())
                                            ],
                                        ],],
 
      ['label' => app\models\ptb\Recommendation::totalPendingPp(Yii::$app->user->getId()),
        'items' => [    
                                            [
                                                'label' => app\models\ptb\Recommendation::totalPendingPp(Yii::$app->user->getId())
                                            ],
                                        ],],
         ['label' => app\models\ptb\Recommendation::totalPendingKj(Yii::$app->user->getId()),
        'items' => [                       ['label' => ''],
                                            [
                                                'label' => app\models\ptb\Recommendation::totalPendingKj(Yii::$app->user->getId())
                                            ],
                                             [
                                                'label' => app\models\ptb\TblTugas::totalPendings(Yii::$app->user->getId())
                                            ],
                                            [
                                                'label' => app\models\ptb\Application::totalPendings(Yii::$app->user->getId())
                                            ],
                                             ['label' => ''],
                                        ],],
     ['label' => app\models\ptb\Recommendation::totalPendingPelulus(Yii::$app->user->getId()),
        'items' => [                        ['label' => ''],
                                            [
                                                'label' => app\models\ptb\Recommendation::totalPendingPelulus(Yii::$app->user->getId())
                                            ],
                                            ['label' => ''],
                                            ['label' => ''],
                                            ['label' => ''],
                                            ['label' => ''],
                                            ['label' => ''],
                                        ],],
       ['label' => ''],
       ['label' => ''],
       ['label' => ''],
       ['label' => ''],
       ['label' => ''],
       ['label' => ''],
       ['label' => ''],

]]); ?>