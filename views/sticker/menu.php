 
<?=

\app\widgets\TopMenuWidget::widget(['top_menu' => [166, 171, 1197, 1233, 1231,1393,1404,1414,1416,1427,1436,1451], 'vars' => [
        ['label' => ''],
        ['label' => app\models\esticker\TblStickerStaf::totalPendingAll(['MENUNGGU BAYARAN KAUNTER','MENUNGGU KUTIPAN']),
            'items' => [  
                [
                    'label' => app\models\esticker\TblStickerStaf::totalPending(['MENUNGGU BAYARAN KAUNTER'])
                ],
                [
                    'label' => app\models\esticker\TblStickerStaf::totalPending(['MENUNGGU KUTIPAN'])
                ], 
                ['label' => ''],
                [
                    'label' => app\models\esticker\TblStickerJabatan::totalPending(['MENUNGGU KUTIPAN'])
                ], 
                
            ],],
        ['label' => app\models\esticker\TblStickerStudent::totalPending(['DIHANTAR', 'MENUNGGU KUTIPAN']),
            'items' => [
                [
                    'label' => app\models\esticker\TblStickerStudent::totalPending(['DIHANTAR'])
                ],
                [
                    'label' => app\models\esticker\TblStickerStudent::totalPending(['MENUNGGU KUTIPAN'])
                ], 
            ],],
        ['label' => ''],
        ['label' => ''],
        ['label' => ''],
     ['label' => ''],
    ['label' => ''],
    ['label' => ''],
    ['label' => ''],
    ['label' => '']
]]);
?> 

