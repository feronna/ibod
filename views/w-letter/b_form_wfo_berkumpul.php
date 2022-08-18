<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper; 
?>   
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

<center><strong><h2><?= $title; ?> Permohonan</h2></strong></center><br/><br/>  
 
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh: 
    </label>
    <div class="col-md-4 col-sm-4 col-xs-12">  
        <?php
        echo $form->field($model, 'tarikh', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
            'options' => ['class' => 'drp-container'],
            'showLabels' => false,
        ])->widget(DateRangePicker::classname(), [
            'useWithAddon' => true,
            'startAttribute' => 'StartDate',
            'endAttribute' => 'EndDate',
            'convertFormat' => true,
            'readonly' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d',
                    'separator' => ' to '
                ],
                'opens' => 'left',
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
