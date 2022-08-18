<div class="col-md-12 col-sm-12 col-xs-12">
    <?=
    \app\widgets\TopMenuWidget::widget(['top_menu' => [88,92,194], 'vars' => [
            ['label' => ''],
            ['label' => '',
                'items' => [
                    [
                        'label' => app\models\guarantee_letter\TblPermohonan::totalPending()
                    ], 
                ],]
    ]]);
    ?>  
 </div>

