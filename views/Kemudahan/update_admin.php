<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Refaccess;
error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,211], 'vars' => []]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Admin</strong></h2>
                <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
                </div>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">ICNO<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
                 <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\lppums\Tblprcobiodata::find()->all(), 'ICNO', 'ICNO'),
                            'options' => [
                            'placeholder' => 'ICNO'],
                            ])->label(false); ?>
               
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">ADMIN POST<span class="required"> *</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'admin_post')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(Refaccess::find()->all(), 'access_level', 'access_type'),
                            'options' => [
                            'placeholder' => 'Admin Post'],
                            ])->label(false); ?>
            
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
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


 

