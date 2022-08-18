<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. K/P: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'ICNO')->textInput(['disabled' => true, 'value' => $model->pekerja->ICNO])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group"> 
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'CONm')->textInput(['disabled' => true, 'value' => $model->pekerja->CONm])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Telefon Bimbit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'COOffTelNo')->textInput(['disabled' => true, 'value' => $model->pekerja->COOffTelNo])->label(false); ?>
                </div>
            </div>
        </div>

        <?php if (in_array($url, ['carian-senarai-kontraktor-aktif', 'rekod-senarai-kontraktor-aktif','senarai-masuk-pekerja'])) { ?> 
            <div class="hide">       
                <?= $form->field($model, 'flag')->hiddenInput(['value' => 2])->label(false); ?>  
                <?= $form->field($model, 'flag_created_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
                <?= $form->field($model, 'flag_created_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?>
            </div>            
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Ulasan&nbsp; <span class="label label-primary">Baru</span>&nbsp;:  <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-5 col-sm-5 col-xs-6"> 
                        <?php if (in_array($url, ['senarai-masuk-pekerja'])) { ?> 
                            <?= $form->field($model, 'flag_open_reason')->textarea(array('rows' => 3))->label(false); ?>

                        <?php } else { ?>
                            <?= $form->field($model, 'flag_open_reason')->textarea([array('rows' => 3),'disabled' => true])->label(false); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } elseif (in_array($url, ['carian-senarai-hitam-kontraktor', 'rekod-senarai-hitam-kontraktor'])) { ?>
            <div class="hide"> 
                <?= $form->field($model, 'flag')->hiddenInput(['value' => 0])->label(false); ?>  
                <?= $form->field($model, 'flag_updated_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
                <?= $form->field($model, 'flag_updated_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Ulasan&nbsp; <span class="label label-primary">Baru</span>&nbsp;:  <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-5 col-sm-5 col-xs-6"> 
                        <?= $form->field($model, 'flag_open_reason')->textarea([array('rows' => 3), 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Ulasan&nbsp;<span class="label label-danger">Tutup Kes</span>&nbsp;:  <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-5 col-sm-5 col-xs-6"> 
                    <?= $form->field($model, 'flag_closed_reason')->textarea(array('rows' => 3))->label(false); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (in_array($url, ['carian-senarai-kontraktor-aktif', 'rekod-senarai-kontraktor-aktif', 'carian-senarai-hitam-kontraktor', 'rekod-senarai-hitam-kontraktor','senarai-masuk-pekerja'])) { ?> 

            <div class="form-group text-center">
                <div class="row">
                    <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                </div>
            </div>   
        <?php } ?>
         
        <?php ActiveForm::end(); ?>

    </div>
</div> 
