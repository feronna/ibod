<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Syarikat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?=
                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->where(['>','DATE(tarikhtamatsah)',date('Y-m-d')])->all(), 'apsu_suppid', 'apsu_lname'),
                        'options' => ['class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Permit (Pekerja): <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'no_permit')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Maklumat Suntikan Pengendali Makanan:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?php
                    if (empty($model->filename_vaksin_pm)) {
                        echo $form->field($model, 'kt_vaksin_pm')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_vaksin_pm), Yii::$app->FileManager->DisplayFile($model->filename_vaksin_pm), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'kt_vaksin_pm'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Maklumat Sijil Pengendali Makanan:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?php
                    if (empty($model->filename_sijil_pm)) {
                        echo $form->field($model, 'kt_sijil_pm')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_sijil_pm), Yii::$app->FileManager->DisplayFile($model->filename_sijil_pm), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'kt_sijil_pm'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Sijil/Kad CIDB (Pekerja):  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <?php
                    if (empty($model->filename_kad_cidb)) {
                        echo $form->field($model, 'kt_kad_cidb')->fileInput(['maxlength' => true])->label(false);
                    } else {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename_kad_cidb), Yii::$app->FileManager->DisplayFile($model->filename_kad_cidb), ['target' => '_blank']) . '&nbsp;&nbsp;&nbsp;' . Html::a('<i class="fa fa-trash"></i>', ['delete-file', 'id' => $model->id, 'title' => 'kt_kad_cidb'], ['class' => 'btn btn-danger btn-sm']);
                    }
                    ?> 
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Peribadi</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. K/P: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="form-group"> 
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'CONm')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group"> 
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Tarikh Lahir: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'COBirthDt',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => 'required'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?> 
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jantina: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6"> 
                        <?=
                        $form->field($model, 'GenderCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Jantina::find()->all(), 'GenderCd', 'Gender'),
                            'options' => ['placeholder' => 'Pilih Jantina', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Agama: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-4"> 
                        <?=
                        $form->field($model, 'ReligionCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Agama::find()->all(), 'ReligionCd', 'Religion'),
                            'options' => ['placeholder' => 'Pilih Agama', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Warganegara: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-4"> 
                        <?=
                        $form->field($model, 'CountryCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                            'options' => ['placeholder' => 'Pilih Negara', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Telefon Bimbit: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-4"> 
                        <?= $form->field($model, 'COOffTelNo')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat 1: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'Addr1')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat 2:  
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'Addr2')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat 3:  
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'Addr3')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Poskod: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                        <?= $form->field($model, 'Postcode')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Bandar: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                        <?=
                        $form->field($model, 'CityCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Bandar::find()->orderBy(['CityCd' => SORT_ASC])->all(), 'CityCd', 'City'),
                            'options' => ['placeholder' => 'Pilih Bandar', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Daerah: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                        <?=
                        $form->field($model, 'StateCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Negeri::find()->orderBy(['StateCd' => SORT_ASC])->all(), 'StateCd', 'State'),
                            'options' => ['placeholder' => 'Pilih Daerah', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div> 

            <div class="hide">
                <?php if (Yii::$app->controller->action->id == 'tambah-pelawat') { ?>

                    <?= $form->field($model, 'created_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
                    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
                <?php } else { ?>
                    <?= $form->field($model, 'updated_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
                    <?= $form->field($model, 'updated_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 

                <?php } ?>
            </div>


            <div class="form-group text-center">
                <div class="row">
                    <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                </div>
            </div>   
            <?php ActiveForm::end(); ?>

        </div>
    </div> 
