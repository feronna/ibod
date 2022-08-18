<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <h2>Tujuan Permohonan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">   
                <?=
                $form->field($model, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">   
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
            <?= \yii\helpers\Html::a('Batal', ['carian-set-jadual-hari'], ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Tambah', ['class' => 'btn btn-primary']) ?>
        </div>

    </div> 
</div>
<?php ActiveForm::end(); ?> 

 