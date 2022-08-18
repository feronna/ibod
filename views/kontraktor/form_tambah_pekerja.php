<?php

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;  
use yii\helpers\ArrayHelper; 
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Bangsa;
use app\models\hronline\Etnik; 
use app\models\hronline\JenisDarah; 
use app\models\hronline\TarafPerkahwinan; 
use app\models\hronline\StatusWarganegara; 

?> 
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="x_panel"> 
    <div class="x_title">
       <h2>Tambah Pekerja </h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Syarikat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?php
//                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->where(['>','DATE(tarikhtamatsah)',date('Y-m-d')])->all(), 'apsu_suppid', 'apsu_lname'),
//                        'options' => ['class' => 'form-control col-md-7 col-xs-12'],
//                        'pluginOptions' => [
//                            'allowClear' => true
//                        ],
//                    ]);
                    ?>
                    <?=
                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\Kontraktor\SyarikatKontraktor::find() ->all(), 'apsu_suppid', 'name'),
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
                        <?=  $form->field($model, 'no_permit')->textInput(['maxlength' => true])->label(false); ?>
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
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Pekerja </h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. K/P: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true]) ->label(false);?>  
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($model, 'CONm')->textInput(['maxlength' => true]) ->label(false);?> 
                    <?php
//                         $form->field($permohonan, 'card_type')->label(false)->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(Refjeniskad::find()->all(), 'id', 'card_type'),
//                        'options' => ['placeholder' => 'Pilih Jenis Kad', 'class' => 'form-control col-md-7 col-xs-12'],
//                        'pluginOptions' => [
//                            'allowClear' => true
//                        ],
//                        ]);
                        ?>
                </div>
            </div> 
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Agama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
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
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bangsa: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                 <?=
                        $form->field($model, 'RaceCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Bangsa::find()->all(), 'RaceCd', 'Race'),
                            'options' => ['placeholder' => 'Pilih Bangsa', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Etnik: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                 <?=
                        $form->field($model, 'EthnicCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Etnik::find()->all(), 'EthnicCd', 'Ethnic'),
                            'options' => ['placeholder' => 'Pilih Etnik', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>

                </div>
            </div>
            
<!--            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Darah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?=
                        $form->field($model, 'BloodTypeCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(JenisDarah::find()->where(['isActive' => 1])->all(), 'BloodTypeCd', 'BloodType'),
                            'options' => ['placeholder' => 'Pilih Jenis Darah', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>


                </div>
            </div>-->
            
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Status Perkhawinan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-6"> 
                         <?=
                            $form->field($model, 'MrtlStatusCd')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TarafPerkahwinan::find()->all(), 'MrtlStatusCd', 'MrtlStatus'),
                                'options' => ['placeholder' => 'Pilih Taraf Perkahwinan', 'class' => 'form-control col-md-7 col-xs-12'],
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Sijil Lahir: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($model, 'COBirthCertNo')->textInput(['maxlength' => true])->label(false) ?>

                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lahir: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
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
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara Kelahiran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?=
                        $form->field($model, 'COBirthCountryCd')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                            'options' => [
                                'placeholder' => 'Pilh Negara',
                            ],
                        ])->label(false);
                        ?> 
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Warganegara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
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
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Warganegara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?=
                        $form->field($model, 'NatStatusCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(StatusWarganegara::find()->all(), 'NatStatusCd', 'NatStatus'),
                            'options' => [
                                'placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript:if ($(this).val() == "1"){ $("#warganegara").show();}
                                else{$("#warganegara").hide();}'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?> 
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mel : <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'COEmail')->textInput(['maxlength' => true,])->label(false) ?>
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Bimbit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($model, 'COOffTelNo')->textInput(['maxlength' => true])->label(false); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                   <?= $form->field($model, 'Addr1')->textInput(['maxlength' => true])->label(false); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Poskod : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?= $form->field($model, 'Postcode')->textInput(['maxlength' => true])->label(false); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bandar : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
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
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Negeri : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <?=
                        $form->field($model, 'StateCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Negeri::find()->orderBy(['StateCd' => SORT_ASC])->all(), 'StateCd', 'State'),
                            'options' => ['placeholder' => 'Pilih Negeri', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >ID MySejahtera : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'mySejahteraId')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div> 

             
            <div class="form-group text-center">
               <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
               <button class="btn btn-primary" type="reset">Reset</button>
            </div>

        </div>
    </div>  

     

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

</div>