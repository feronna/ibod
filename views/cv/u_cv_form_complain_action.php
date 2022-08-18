<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cv\TblAccess;
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">COMPLAIN DETAILS</p>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Staff Name: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  
                <?= $form->field($model, 'name')->textInput(['value' => $model->biodata->CONm, 'readonly' => true])->label(false); ?>
            </div>
        </div> 
        <?php if (TblAccess::isAdminAcademic() || TblAccess::isAdminDataOwner()) { ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Criteria: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                $form->field($model, 'kriteria_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefKriteria::find()->all(), 'id', 'type'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div>  
        <?php } ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Justification: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?= $form->field($model, 'justifikasi')->textarea(['rows' => 6, 'readonly' => true])->label(false); ?>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                $form->field($model, 'status_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefStatusAduan::find()->where(['!=', 'id', 1])->all(), 'id', 'output'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?= $form->field($model, 'catatan')->textarea(['rows' => 6])->label(false); ?>
            </div>
        </div>


        <div class="form-group text-center">
            <?php
            if ($model->status_id != 3) {
                echo Html::a('CANCEL', Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']);
                echo Html::submitButton('SAVE', ['class' => 'btn btn-success btn-sm']);
            } else {
                echo Html::a('BACK', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']);
            }
            ?>
        </div>

<?php ActiveForm::end(); ?> 
    </div>
</div> 

