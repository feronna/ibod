<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>  
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">NOTIFICATIONS</p>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">     
        <div class="form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status: <span class="required" style="color:red;">*</span>
            </label>
            <?php if($model->jawatan->svc ==1 ){ ?>
            <div class="col-md-6 col-sm-6 col-xs-12">  
                <?php
                if ($model->status_id == 3) {
                    $data = [4, 5];
                } else {
                    $data = [3, 4, 5];
                }
                ?>
                <?=
                $form->field($model, 'status_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefStatus::find()
                                    ->where(['IN', 'id', $data])
                                    ->all(), 'id', 'name'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);
                ?>
            </div> 
            <?php }else{ ?>
            <div class="col-md-6 col-sm-6 col-xs-12">   
              
                <?=
                $form->field($model, 'admin_status')->widget(Select2::classname(), [
                    'data' => [1=>'Offer Iv',2=>'Failed (Tapisan)',3 => 'Failed (Pemilihan)'],
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);
                ?>
            </div> 
            <?php } ?>
        </div>     
        <div class="form-group text-center">
            <?= Html::a('Cancel', ['applications'], ['class' => 'btn btn-danger btn-sm']); ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
        </div>
<?php ActiveForm::end(); ?> 
    </div>
</div> 

