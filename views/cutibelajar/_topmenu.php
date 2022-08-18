 <div class="col-md-12 col-sm-12 col-xs-12">
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [157,162, 160,1220, 1228,1237,1252,
                                                      1255,1356,1275,1484], 'vars' => [
    ['label' => ''],
    ['label' => ''],
    
    ['label' => app\models\cbelajar\TblPermohonan::totalPending(Yii::$app->user->getId(),2),
          'items' => [
               ['label' => ''],
                [
                   'label' =>  app\models\cbelajar\TblPermohonan::totalPending(Yii::$app->user->getId())
                 ],
              
                                            
                                        ],]
]]); ?>
 </div>