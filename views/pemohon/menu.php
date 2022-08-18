<div class="col-md-12 col-sm-12 col-xs-12"> 

    <?=
    \app\widgets\TopMenuWidget::widget(['top_menu' => [138,182], 'vars' => [
            ['label' => app\models\ejobs\TblpPermohonan::totalPending(Yii::$app->user->getId(),1)],
             ['label' => ''],
        ]
    ]);
    ?>
</div>

