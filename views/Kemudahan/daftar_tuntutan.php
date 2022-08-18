<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Refjeniskemudahan;
use app\models\kemudahan\Refakaun;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

?>

<?php $this->title = 'Borang Online';?>
<div class="col-md-12">
   <?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Daftar Jenis Kemudahan</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">    
               <div class="table table-striped jambo_table">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kemudahan<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'jeniskemudahan')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Refjeniskemudahan::find()->all(), 'kemudahancd', 'kemudahan'),
                    'options' => [
                            'placeholder' => 'Sila Pilih'],

                ]); ?>
                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Akaun<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                
                
                 <?=
                    $form->field($model, 'kodAkaun')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Refakaun::find()->all(), 'akauncd', 'kodAkaun'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => 'Sila Pilih',
                            'depends' => [Html::getInputId($model, 'jeniskemudahan')],
                            'initialize' => true,
                            'url' => Url::to(['/kemudahan/jenis'])
                        ]
                    ])->label(false)
                    ?>

                    
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Jumlah<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?= $form->field($model, 'amount')->label(false);?>
            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah (Total)<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?= $form->field($model, 'total')->label(false);?>
            
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Syarat Permohonan<span class="required"> :</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'syarat')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>
            
            </div>
        </div>
       


        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
                    
                    
                </div>

                
            </div>
        </div>
    </div>
</div>
