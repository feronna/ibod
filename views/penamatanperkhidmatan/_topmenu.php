<?php
    use app\models\penamatanperkhidmatan\TblPermohonan;
    $icno = Yii::$app->user->getId();
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [176, 183, 184, 185, 186, 187, 188, 189, 190, 191,195], 'vars' => [
['label' => ''],
    ['label' => TblPermohonan::totalPendingpp($icno)],
    ['label' => TblPermohonan::totalPendingbn()],
    ['label' => TblPermohonan::totalPendingkj($icno)],
    ['label' => TblPermohonan::totalPendingperpustakaan()],
    ['label' => TblPermohonan::totalPendingjtmk()],
    ['label' => TblPermohonan::totalPendingppuu()],
    ['label' => TblPermohonan::totalPendingpppi()],
    ['label' => TblPermohonan::totalPendingbsm()],
    
]]); ?>