<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2; 
use dosamigos\datepicker\DatePicker;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Kemaskini Surat Kebenaran</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">     
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai 1:</label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                    $form->field($model, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai 2:</label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                    $form->field($model, 'pegawai2')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tajuk:</label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                    $form->field($model, 'title')->textarea(['maxlength' => true,'rows'=>5])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Arahan Pentadbiran:</label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'tarikh_AP',
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
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div>  

