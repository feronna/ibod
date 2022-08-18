<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Kenderaan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama Pemilik: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($pelekat, 'apply_type')->textInput(['disabled' => true, 'value' => $pelekat->kenderaan->veh_owner])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($pelekat, 'id_kenderaan')->textInput(['disabled' => true, 'value' => $pelekat->kenderaan->reg_number])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($pelekat, 'apply_type')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>


    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Pembayaran</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($invoice, 'customer_name')->textInput(['disabled' => true])->label(false); ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <?= Html::a('<i class="fa fa-edit"></i>', ['biodata/kemaskini'], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($invoice, 'contact_no')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Emel: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?= $form->field($invoice, 'email')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jumlah (RM): <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($invoice, 'amount')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Bayaran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 

                    <?php
                    $kaunter = '<img src="../images/sticker/kaunter.png" width="22%" height="180%">';
                    $debit = '<img src="../images/sticker/debit.png" width="9%" height="48%">';
                    $m_card = '<img src="../images/sticker/m_card.png" width="30%" height="250%">';
                    

                    if ($invoice->payment_method) {
                        echo $form->field($invoice, 'payment_method')->textInput(['disabled' => true])->label(false);
                    } else { 
                        echo $form->field($invoice, 'payment_method')->radioList(array('KAUNTER' => $kaunter.' KAUNTER', 'FPX' => $debit . ' DEBIT/FPX', 'CREDIT_CARD ' => $m_card . ' CARD CREDIT'), ['encode' => false])->label(false);
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right"> Tarikh/Masa pengambilan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-6">  
                    <?=
                    $form->field($pelekat, 'wakil_masa_ambil')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => '....'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ])->label(false);
                    ?>
                </div>
            </div>
        </div>  

    </div>
</div>

<div class="x_panel"> 
    <div class="x_title">
        <h2>Wakil pengambilan pelekat</h2> <br/><br/> <span class="required" style="color:red;">* Sekiranya perlu.</span>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Kp:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
<?= $form->field($pelekat, 'wakil_ICNO')->textInput([])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
<?= $form->field($pelekat, 'wakil_nama')->textInput([])->label(false); ?>
                </div>
            </div>
        </div> 

        <div class="form-group text-center">
            <div class="row">
<?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Mohon', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>   
<?php ActiveForm::end(); ?>


    </div>
</div> 
