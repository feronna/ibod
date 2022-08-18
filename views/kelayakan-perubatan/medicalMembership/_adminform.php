<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\BadanProfesional;
use app\models\hronline\ProfesionalAssociationLevel;
use app\models\hronline\TarafKeahlian;

?>

<div class="tbl-badan-profesional-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="BadanProfesional">Nama Organisasi: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'ProfBodyCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(BadanProfesional::find()->where(['isActive'=>1])->andWhere(['isMedicalBody'=>1])->orderBy(['ProfBody'=> SORT_ASC])->all(), 'ProfBodyCd', 'ProfBody'),
                        'options' => ['placeholder' => 'Pilih Organisasi', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarafKeahlian">Taraf Keahlian: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'MembershipTypeCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TarafKeahlian::find()->where(['isActive'=>1])->orderBy(['MembershipType'=> SORT_ASC])->all(), 'MembershipTypeCd', 'MembershipType'),
                        'options' => ['placeholder' => 'Pilih Taraf Keahlian', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Peringkat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'ProfAssocLvl')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(ProfesionalAssociationLevel::find()->where(['isActive'=>1])->orderBy(['id'=> SORT_ASC])->all(), 'id', 'LvlNm'),
                        'options' => ['placeholder' => 'Pilih Peringkat', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Keahlian: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'membership_no')->textInput(['maxlength' => true])->label(false) ?> 
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Jawatan">Jawatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'Designation')->textInput(['maxlength' => true])->label(false) ?> 
                </div>
            </div>    

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhMulaMenyertai">Tarikh Mula Menyertai: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'JoinDt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Tarikh Tamat Menyertai: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'ResignDt',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="YuranDikenakan">Yuran Dikenakan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'FeeAmt')->textInput(['placeholder'=>'RM'],['maxlength' => true])->label(false) ?>
                </div>
            </div>   
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >URL: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'url')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>   

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Status Keahlian: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ProfAssocStatus')->checkbox(['label' => 'Tandakan jika masih aktif', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muatnaik Dokumen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                   <?php 
                    if( $model->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($model->filename ? $msg =  Yii::$app->FileManager->NameFile($model->filename) : $msg = 'Please provide related file.'));
                    echo $form->field($model, 'file')->fileInput()->label($msg . " (Max size 6.0 MB)");?>
                </div>
            </div>

        </div>
    </div>        
    <div class="form-group text-center">
        <?= Html::a('Kembali', ['admin-view','icno'=>$model->ICNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
