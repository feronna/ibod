<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>  
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">ASSIGN</p>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Data Owner: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">  
                <?php
                
                $owner = \app\models\cv\TblAccess::find()->where(['access'=>3])->select('ICNO')->asArray()->all();
                
                echo $form->field($model, 'assign_to')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find() 
                            ->where(['IN','ICNO',$owner])
                            ->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true, 
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="hide">  
                <?= $form->field($model, 'assign_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($model, 'assign_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
            </div>
        </div>     
        <div class="form-group text-center">
            <?= Html::a('Cancel', ['record-complain'], ['class' => 'btn btn-danger btn-sm']); ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div> 
 
