<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $iklan app\iklans\ejobs\Iklan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered jambo_table table-striped"> 
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jawatan: </th><td><?= $iklan->jawatan->fname; ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Kumpulan: </th><td><?= $iklan->kumpulan->name; ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Klasifikasi: </th><td><?= $iklan->klasifikasi->name; ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Kategori: </th><td><?= $iklan->kategori->name; ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Penempatan: </th><td><?= $iklan->penempatan->campus_name; ?></td> 
        </tr> 
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Taraf Jawatan: </th>
            <td>
                <?php foreach ($taraf_jawatan as $taraf_jawatan) { ?>
                    <?= $taraf_jawatan->taraf->ApmtStatusNm; ?> ,
                <?php } ?> 
            </td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jadual Gaji: </th><td>RM <?= $iklan->gaji->r_jg_min; ?> - RM <?= $iklan->gaji->r_jg_maks; ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jumlah Kekosongan: </th><td><?= $iklan->jumlah_kekosongan; ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Tarikh Buka: </th><td><?= $iklan->getTarikh($iklan->tarikh_buka); ?></td> 
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Tarikh Tutup: </th><td><?= $iklan->getTarikh($iklan->tarikh_tutup); ?></td>  
        </tr> 

    </table>
</div>

<?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

<?= $form->field($iklan, 'status')->hiddenInput(['value' => 1])->label(false); ?> 

<div class="form-group"> 
    <p align = "right"> 
        <?= Html::a('Batal', ['bsm/halaman-utama'], ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Aktif', ['class' => 'btn btn-success']) ?> 
</p>
</div>

<?php ActiveForm::end(); ?> 
<?php yii\widgets\Pjax::end() ?> 