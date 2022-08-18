<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>


<?php

?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Tindakan Ketua Jabatan</strong></h2>
                 <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/halaman-kj'], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
               
                             <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Kelulusan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                        $form->field($model, 'kj_agree')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'DILULUSKAN', 2 => 'DITOLAK'],
                            'options' => ['placeholder' => 'Pilih Kelulusan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                      
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Perakuan Ketua Jabatan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'perakuan_kj')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                        </div>
                    </div>
                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Adakah anda pasti dengan tindakan ini?']]) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <!--form-->
            </div>
            </div>
        </div>
    </div>
</div>

