<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

    <div class="x_panel"> 
        <div class="x_title">
            <h2>  
                <?php
                if($permohonan->status_semasa == 2){
                    echo "Surat - Bahagian 3. ";
                    $title = "Teks";
                }else{
                    echo "Ulasan Permohonan Ditolak ";
                    $title = "Sebab";
                } 
                ?>
            </h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $title;?>: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($permohonan, 'approved_text')->textarea(['rows'=>6])->label(false);
                    ?> 
                </div>
            </div>
            <div class="hide"> 
                <?= $form->field($permohonan, 'status_notifikasi')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'tarikh_notifikasi')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
            </div>
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

