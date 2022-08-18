<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\popover\PopoverX;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\esticker\TblStickerStaf */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="x_panel">  
    <div class="x_title">
        <h2>Maklumat Kontraktor</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php
        if ($record) {
            ?>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama Syarikat/Pemilik: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record, 'apsu_lname')->textInput(['disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengguna Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">    
                    <?= $form->field($kenderaan, 'veh_user')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Hubungan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">    
                    <?= $form->field($kenderaan, 'rel_owner_user')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">    
                    <?= $form->field($kenderaan, 'reg_number')->textInput(['disabled' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kenderaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">    
                    <?= $form->field($kenderaan, 'veh_type')->textInput(['value' => $kenderaan->jenisKenderaan->Keterangan, 'disabled' => true])->label(false); ?>
                </div>
            </div>

            <?php
        }
        ?> 
        <br/>   <br/>   
    </div>
</div>

<div class="x_panel">  

    <?php if (!empty($exist)) { ?>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jenis Permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?=
                    $form->field($model, 'apply_type')->label(false)->widget(Select2::classname(), [
                        'data' => ['LANJUTAN' => 'LANJUTAN', 'ROSAK' => 'ROSAK', 'HILANG' => 'HILANG'],
                        'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div> 
        <?php
    } else {

        echo $form->field($model, 'apply_type')->hiddenInput(['value' => 'BARU'])->label(false);
    }
    ?>


    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisLesen">Harga Pelekat (RM): <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">

            <?= $form->field($model, 'total')->textInput(['disabled' => true])->label(false); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Pelekat: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">    
            <?php
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'expired_date',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => 'true'],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>  
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">     
            <?php
            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'expired_date_2',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => 'true'],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?> 
        </div>
    </div> 

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLese">No. Siri:  
            <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <?= $form->field($model, 'kod_siri')->textInput(['disabled' => true])->label(false); ?>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <?= $form->field($model, 'siri')->textInput(['maxlength' => true])->label(false); ?>
        </div> 
        <div class="col-md-2 col-sm-2 col-xs-12">
            <?=
            PopoverX::widget([
                'header' => '<span style="color:black;"><strong> RUJUKAN NO.SIRI PELEKAT </strong></span>',
                'type' => PopoverX::TYPE_SUCCESS,
                'placement' => PopoverX::ALIGN_BOTTOM,
                'content' =>
                'KERETA STAF : KS123456 <br/>
                                                                                KERETA PELAJAR : KP123456 <br/>
                                                                                MOTOR STAF : MS123456 <br/>
                                                                                MOTOR PELAJAR : MP123456<br/>
                                                                                KERETA KONTRAKTOR : KC123456<br/>
                                                                                MOTOR KONTRAKTOR : MC123456 <br/>
                                                                                KERETA VIP : KVIP123456<br/>
                                                                                MOTOR VIP : MVIP123456 <br/>
                                                                                KERETA PELAWAT : KV123456 <br/>
                                                                                MOTOR PELAWAT : MV123456 <br/>
                                                                                KERETA JABATAN : KJ123456 <br/>
                                                                                MOTOR JABATAN :  MJ123456 <br/>
                                                                                KERETA KHAS : KK123456 <br/>
                                                                                MOTOR KHAS : MK123456',
                'toggleButton' => ['label' => 'RUJUKAN <i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-warning btn-sm'],
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Resit: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">    
            <?= $form->field($model, 'no_resit')->textInput()->label(false); ?>  
        </div>
    </div>
    <br/>
    <div class="form-group text-center">
        <div class="row">
            <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
        </div>
    </div> 
    <div class="hide">  

        <?= $form->field($model, 'expired_date')->hiddenInput(['value' => date('Y') . '-12-31'])->label(false); ?> 
        <?= $form->field($model, 'status_mohon')->hiddenInput(['value' => 'DIHANTAR'])->label(false); ?> 
        <?= $form->field($model, 'updater')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
        <?= $form->field($model, 'app_date')->hiddenInput(['value' => date('Y-m-d')])->label(false); ?>  
    </div>
</div> 

<?php ActiveForm::end(); ?>
