<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\Tblprcobiodata;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Pergigian\Klinik;
use dosamigos\datepicker\DatePicker;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\Pergigian\PergigianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Butiran Tuntutan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>

        <div class="clearfix"></div>   
        </div>

        <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nama Klinik Pergigian<span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=$form->field($model, 'klinik_gigi_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Klinik::find()->all(), 'klinik_gigi_id','klinik_nama'),
                        'options' => ['placeholder' => 'Pilih Klinik Gigi', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                        <br>                      
                    </div>
                </div>
      
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">Tarikh Rawatan <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <!--<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">-->
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'used_dt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Tuntutan (RM)<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'jumlah_tuntutan')->widget(NumberControl::classname(), [
                         'name' => 'jumlah_tuntutan',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Bil/Resit<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>         
           
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
            
            </div>
            </div>
