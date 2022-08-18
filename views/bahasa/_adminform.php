<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\NamaBahasa;
use app\models\hronline\TahapKemahiranBahasa;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblbahasa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblbahasa-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
    
    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
    
    
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaBahasa">Nama Bahasa: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
 
            <?=
            $form->field($model, 'LangCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(NamaBahasa::find()->where(['isActive'=>1])->all(), 'LangCd', 'Lang'),
                'options' => ['placeholder' => 'Pilih Bahasa', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisAlamat">Kemahiran Lisan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            
            <?=
            $form->field($model, 'LangSkillOral')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TahapKemahiranBahasa::find()->where(['isActive'=>1])->all(), 'LangProficiencyCd', 'LangProficiency'),
                'options' => ['placeholder' => 'Pilih Tahap Kemahiran', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisAlamat">Kemahiran Menulis: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
           
            <?=
            $form->field($model, 'LangSkillWritten')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TahapKemahiranBahasa::find()->where(['isActive'=>1])->all(), 'LangProficiencyCd', 'LangProficiency'),
                'options' => ['placeholder' => 'Pilih Tahap Kemahiran', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusPengiktirafan">Sijil Kemahiran: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          
            <?= $form->field($model, 'LangSkillCert')->checkbox(['label' => 'Tandakan jika Ada', 'value' => 1, 'uncheck' => 0])->label(false) ?>
            
        </div>
        </div>    

    
    
    
         </div>
    </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a( 'Kembali', ['adminview','icno'=>$model->ICNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success','data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>
        
</div>

