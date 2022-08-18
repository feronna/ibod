<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $iklan app\iklans\ejobs\Iklan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered jambo_table table-striped"> 
        
        </tr>
        <tr>
            <th class="col-md-2 col-sm-3 col-xs-12 text-right">Kategori: </th><td><?= $iklan->kategori->name; ?></td> 
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
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'data-pjax' => true]]); ?>

<?= $form->field($iklan, 'status')->hiddenInput(['value' => 1])->label(false); ?> 

<div class="form-group"> 
    <p align = "right"> 
        
       <?= Html::submitButton('Aktifkan', ['class' => 'btn btn-success']) ?> 
       <?= Html::a('Kemaskini', ['edit-iklan', 'id' => $iklan->id], ['class' => 'btn btn-primary']) ?>
       <?= Html::a('Padam', ['delete-iklan', 'id' => $iklan->id], ['class' => 'btn btn-warning']) ?>
       <?= Html::a('Batal', ['halaman-utama-bsm'], ['class' => 'btn btn-danger']) ?>

</p>
</div>

<?php ActiveForm::end(); ?> 
<?php yii\widgets\Pjax::end() ?> 