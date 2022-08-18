<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\penamatanperkhidmatan\TblExitinterview;

error_reporting(0);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    ::placeholder{
        color:#ede7f6;
    }
</style>
<?= $this->render('_topmenu') ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


        <div class="col-md-10 col-sm-10 col-xs-12 center-margin">  
    <div class="x_panel">
        <h2 align="center"><strong>BORANG "EXIT INTERVIEW" PEKERJA UNIVERSITI</strong></h2>
        <br>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JAWATAN SEKARANG & GRED : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">GAJI : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">TEMPOH PERKHIDMATAN : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tempohperkhidmatan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div><br>
            <?php $no=0; foreach($soalan as $s){ $no++;?>
            <div class="form-group">
                <label style="font-size: 16px;" class="col-md-12 col-sm-12 cclol-xs-12"><?= $no.'. '.$s->soalan_bm.' / <i>'.$s->soalan_bi.'</i>'?> : <span class="required"></span>
                </label><br>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <textarea placeholder="Jawapan Anda" style="border:none; border-bottom: solid; width:100%;" required="true" name="jawapan<?= $s->id?>">
<?php if(TblExitinterview::find()->where(['icno' => Yii::$app->user->getId()])){ echo TblExitinterview::find()->where(['icno' => Yii::$app->user->getId(), 'soalan_id'=> $s->id])->one()->jawapan;}?></textarea>
                </div>
            </div><br>
            <?php }?>
        </div>

            <div class="form-group" align="center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>
