<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\RefKriteria;
use app\models\cbelajar\RefStatusAduan;
?> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Aduan</h2> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">     
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  
                <?= $form->field($model, 'name')->textInput(['value' => $model->biodata->CONm, 'readonly' => true])->label(false); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kriteria: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                $form->field($model, 'kriteria_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(RefKriteria::find()->all(), 'id', 'type'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div>  
      
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
                    'data' => ArrayHelper::map(RefStatusAduan::find()->where(['!=', 'id', 1])->all(), 'id', 'output'),
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

