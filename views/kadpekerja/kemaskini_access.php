<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use kartik\grid\GridView;
use yii\helpers\ArrayHelper; 

error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1319,1322,1324,1326], 'vars' => []]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Akses</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">ICNO<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 
            <input type="text" class="form-control" value="<?php echo $model->icno;?>" disabled="disabled">
                
            </div>
        </div>
<!--        <div class="form-group" >
                        <span style="color:green;" class="required" align="centre">1 = Pegawai Keselamatan, 2 = Ketua Seksyen</span><br>

        </div>-->
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Access Level <span class="required"> *</span>
            </label><br>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php //$form->field($model, 'access_level')->textInput(['maxlength' => true]) ->label(false);?> 
                <?= $form->field($model, 'access_level')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    '1' => 'Ketua Seksyen', 
                                    '2' => 'Pegawai Tadbir',
                                    '3' => 'Pegawai Keselamatan KP29 / KP32', 
                                   
                                
                             ],
                                'options' => [
                                        'placeholder' => 'Sila Pilih'],

                            ]); ?> 
                <?php
//                $form->field($model, 'admin_post')->widget(Select2::classname(), 
//                            ['data' => ArrayHelper::map(Refaccess::find()->all(), 'access_level', 'access_type'),
//                            'options' => [
//                            'placeholder' => 'Admin Post'],
//                            ])->label(false); 
                ?>
               
              
            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
                <?php $model->isActive = 0; ?>
                <?= $form->field($model, 'isActive')->checkbox()->label(false); ?>


              
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>


 


