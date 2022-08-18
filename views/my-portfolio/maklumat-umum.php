<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>


<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel" style="display: <?php echo $displaymohon;?>">
        <div class="x_title">
            <h2>Maklumat Umum</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">GELARAN JAWATAN
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper(Yii::$app->user->getIdentity()->jawatan->nama)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">RINGKASAN GELARAN JAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'ringkasan_gelaran')->textarea(['maxlength' => true, 'placeholder' => "Contoh: Pen.Peg Teknologi Maklumat"])->label(false) ?>
            </div>
            </div>
            
            <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">GRED JAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                      <?= $form->field($model, 'gred_jawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->orderBy(['gred' => SORT_ASC])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Pilih Gred Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
            </div>
            </div>
            
              <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">GRED JD
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper(Yii::$app->user->getIdentity()->jawatan->gred)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS JAWATAN
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper(Yii::$app->user->getIdentity()->statusLantikan->ApmtStatusNm)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
            
             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">HIRARKI 1 (BAHAGIAN)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper(Yii::$app->user->getIdentity()->department->fullname)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
            
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">HIRARKI 2 (CAWANGAN/SEKTOR/UNIT)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'hirarki_2')->textarea(['maxlength' => true, 'placeholder' => "Contoh: Teknologi Maklumat"])->label(false) ?>
            </div>
            </div>
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">SKIM PERKHIDMATAN
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper(Yii::$app->user->getIdentity()->jawatan->skimPerkhidmatan->name)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
            
               <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">KETUA PERKHIDMATAN
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="KETUA PERKHIDMATAN" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
              </div>
            
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">KEDUDUKAN DI WARAN PERJAWATAN
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="TIDAK BERKENAAN" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
              </div>
            
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">BIDANG UTAMA<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'bidang_utama')->textarea(['maxlength' => true, 'placeholder' => "Contoh: Perjawatan"])->label(false) ?>
            </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">SUB BIDANG<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'sub_bidang')->textarea(['maxlength' => true, 'placeholder' => "Contoh: Kenaikan Pangkat"])->label(false) ?>
            </div>
            </div>
            
            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">DISEDIAKAN OLEH
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= strtoupper(Yii::$app->user->getIdentity()->CONm)?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
            </div>
            
                 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH DOKUMEN
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= date("d/m/ Y") ?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                 </div>

      

           
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>


