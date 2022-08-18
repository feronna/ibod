<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


?>


    <div class="x_panel" >
              <p align="right"> 
    
            <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="x_title">
            <h2><strong>Mesyuarat Jawatankuasan Tatatertib Kakitangan</strong></h2>
        
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <div class="table-responsive">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
            
        <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Mesyuarat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'nama_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
        </div>
       
            
            
         
            
                  <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank">Tarikh Mesyuarat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
<?=
                    DatePicker::widget([
                        'model' => $urus,
                        'attribute' => 'tarikh_mesyuarat',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>                </div>
            </div>
            
       
      
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Mesyuarat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'tempat_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="akaun">Kategori Pegawai: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=
                            $form->field($urus, 'kategori')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\tatatertib_staf\RefKategori::find()->all(), 'id', 'kategori_nm'),
                            'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                </div>
            </div>
            
                      <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="akaun">Bidang Kuasa: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=
                            $form->field($urus, 'bidang_kuasa')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\tatatertib_staf\RefBidangKuasa::find()->all(), 'id', 'bidang_kuasa_nm'),
                            'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                </div>
            </div>
            
            
                    <div class="form-group">
            <label class="col-sm-3 control-label">Pengerusi<span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
         
               <?=
                   $form->field($urus, 'pengerusi_icno')->label(false)->  widget(Select2::classname(), [
                    'data' => $dropdown_list_name,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
            
 
   
            
 
        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>




