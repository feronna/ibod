<?php

use yii\helpers\Html;
use kartik\form\ActiveForm; 
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
?>   
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

<center><strong><h2><?= $title; ?> Permohonan</h2></strong></center><br/><br/>  
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh 1: 
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">  
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'date1',
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh 2: 
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">  
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'date2',
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh 3: 
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">  
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'date3',
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh 4: 
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">  
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'date4',
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh 5: 
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">  
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'date5',
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori: <span class="required" style="color:red;">*</span>
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12"> 
        <?=
        $form->field($model, 'kategori')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(app\models\w_letter\RefKategori::find()->all(), 'shortname', 'name'),
            'options' => ['placeholder' => 'Pilih Kategori..'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Tugas: <span class="required" style="color:red;">*</span>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12"> 
        <?=
        $form->field($model, 'tugas')->textarea(['rows' => 6])->label(false);
        ?> 
    </div>
</div> 
<div class="form-group text-center">
    <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    <?= Html::submitButton($title, ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>  
