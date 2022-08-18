<div class="col-md-12 col-sm-12 col-xs-12">
    <?=
    \app\widgets\TopMenuWidget::widget(['top_menu' => [1021,1024], 'vars' => [
            ['label' => ''],
            ['label' => '',
                'items' => [
                    [
                        'label' => app\models\v_letter\TblPermohonan::totalPending()
                    ], 
                ],]
    ]]);
    ?>  
 </div>

