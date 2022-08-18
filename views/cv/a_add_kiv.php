<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>  
<div class="x_panel"> 
    <div class="x_title">
       <p style="font-size:18px;font-weight: bold;">KIV</p>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Position: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">  
                <?php 
                
                echo $form->field($model, 'jawatan_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['IN','id',[10,13,11,205,220,257]])->all(), 'id', 'fname'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true, 
                    ],
                ])->label(false);
                ?>
            </div> 
        </div>     
        <div class="form-group text-center">
            <?= Html::a('Cancel', ['applications'], ['class' => 'btn btn-danger btn-sm']); ?>
            <?= Html::submitButton('Proceed', ['class' => 'btn btn-success btn-sm']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div> 
 
