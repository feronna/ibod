<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<?= $this->render('/kontrak/_topmenu') ?>
<?= $this->render('_inquiry') ?>
<?php if($bolehmohon1 && $bolehmohon1->start_bolehmohon<= date('Y-m-d') &&  $bolehmohon1->end_bolehmohon>= date('Y-m-d')){
    if(!\app\models\kontrak\Kontrak::find()->where(['icno' => $icno, 'sesi_id' => $bolehmohon1->id, 'tahun_sesi' => $bolehmohon1->tahun])->exists()){?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Pelantikan Semula Kontrak</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); 
            $model->scenario = 'bm';?>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Justifikasi Permohonan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'reason')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Pemohon boleh memuat naik dokumen sokongan yang difikirkan perlu. Contoh : Pengiktirafan / Lesen kepakaran / Rekod hospital atau lain-lain 
            </div>
            </div>
        </div>
        <?php if($pp != $model->kakitangan->CONm){?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Mempersetuju :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?php echo $pp?>" disabled="disabled">
            </div>
        </div><?php }?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Memperaku :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?php echo $kj?>" disabled="disabled">
            </div>
        </div>
        <br>
         

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar Permohonan', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
    </div><?php }} elseif($bolehmohon1){?>
<div class="row">
    <div class="x_panel">
        <div class="x_title">PERMOHONAN MASIH DITUTUP</div>
    <div class="x_content">
        Anda boleh membuat permohonan bermula pada 
        <b style="color: green"><?= $bolehmohon1->startmohon?></b> hingga <b style="color: green"><?= $bolehmohon1->endmohon?></b>
    </div>
    </div>
</div>
<?php }?>

