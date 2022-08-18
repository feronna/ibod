<?php
use yii\helpers\Html;
use app\models\penamatanperkhidmatan\TblPermohonan;
?>

<?= $this->render('_topmenu') ?>

<?php if(TblPermohonan::find()->where(['icno' => Yii::$app->user->getId(), 'status_bsm' => NULL])->exists()){?>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>PERMOHONAN PENAMATAN PERKHIDMATAN</strong></h2>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <div style="color:green">
        Permohonan anda berjaya dihantar. Sila lengkapkan borang Exit Interview. Proses pengiraan wang ganjaran hanya akan diproses
        setelah kakitangan mengisi borang ini dan maklumat
        clearance dibuat. 
        </div><br>
         <?= Html::a('<i class="fa fa-hand-o-right"></i> Exit Interview', ['exitinterview'], ['class'=>'btn btn-primary']) ?>
         <?= Html::a('<i class="fa fa-hand-o-right"></i> Status Permohonan', ['statuspermohonan'], ['class'=>'btn btn-primary']) ?>
    </div>
    </div>
</div>
<?php }
else{?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>PERMOHONAN PENAMATAN PERKHIDMATAN</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        <?= $this->render('_jenispermohonan',['model'=>$model]) ?>
    </div>
</div>
    <?php }?>



