<?php

 
use yii\widgets\ActiveForm; 
use app\models\hronline\Agama; 

?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Pekerja</h2> 
        <div class="form-group text-right">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  <br/>    
        <?php
        if ($record) {
            ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. K/P: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($record, 'ICNO')->textInput(['maxlength' => true,'disabled' => true]) ->label(false);?>  
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($record, 'CONm')->textInput(['maxlength' => true,'disabled' => true]) ->label(false);?> 
                    <?php
//                         $form->field($permohonan, 'card_type')->label(false)->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(Refjeniskad::find()->all(), 'id', 'card_type'),
//                        'options' => ['placeholder' => 'Pilih Jenis Kad', 'class' => 'form-control col-md-7 col-xs-12'],
//                        'pluginOptions' => [
//                            'allowClear' => true
//                        ],
//                        ]);
                        ?>
                </div>
            </div> 
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Agama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?= $form->field($record->displayAgama, 'Religion' )->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bangsa: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                 <?= $form->field($record->bangsa, 'Race')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Etnik: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                 <?= $form->field($record->etnik, 'Ethnic')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                </div>
            </div>
            
<!--            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Darah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?= $form->field($record, 'BloodTypeCd')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                  <?php // $form->field($record->displayJenisDarah, 'BloodType')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 

                </div>
            </div>-->
            
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jantina: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6"> 
                      <?= $form->field($record->jantina, 'Gender')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 

                        
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Status Perkhawinan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6"> 
                        <?= $form->field($record->displayTarafPerkahwinan, 'MrtlStatus')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Sijil Lahir: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record, 'COBirthCertNo')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?>

                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lahir: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <?= $form->field($record, 'COBirthDt')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara Kelahiran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    
                   <?= $form->field($record->displayNegaraLahir, 'Country')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?>  
 
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Warganegara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                 <?= $form->field($record->warganegara, 'Country')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
 
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Warganegara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?= $form->field($record->statusWarganegara, 'NatStatus')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
                   
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mel : <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($record, 'COEmail')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?>
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Bimbit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($record, 'COOffTelNo')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($record, 'Addr1')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Poskod : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?= $form->field($record, 'Postcode')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bandar : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?= $form->field($record->displayBandar, 'City')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?>
 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Negeri : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?= $form->field($record->negeriAsal, 'State')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?> 
                  
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >ID MySejahtera : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?= $form->field($record, 'mySejahteraId')->textInput(['maxlength' => true, 'disabled' => true])->label(false) ?>
                </div>
            </div> 
            <?php
        }
        ?> 
        <?php ActiveForm::end(); ?><br/>   <br/>   
        

    </div> 
</div> 
