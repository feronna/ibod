<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use app\models\hronline\JenisAlamat;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use yii\helpers\Url;

$this->title = 'Kemaskini Alamat';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">

        <div class="x_content">
            <div class="tblpraddress-form">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= $this->title; ?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisAlamat">Jenis Alamat: <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                    $form->field($model, 'AddrTypeCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(JenisAlamat::find()->where(['isActive' => 1])->orderBy(['AddrTypeCd' => SORT_ASC])->all(), 'AddrTypeCd', 'AddrType'),
                                        'options' => ['placeholder' => 'Pilih Jenis Alamat', 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'jenisalamat', 'disabled' => 'disabled'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Alamat">Alamat: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'Addr1')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Alamat2">Alamat 2: <span class="required" style="color:red;"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'Addr2')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Alamat3">Alamat 3: <span class="required" style="color:red;"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'Addr3')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>

                    <div class="form-group" id="negara">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negara">Negara: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'CountryCd')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Negara::find()->where(['isActive' => 1])->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                                    'options' => [
                                        'placeholder' => 'Pilh Negara'
                                    ],
                                ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group" id="negeri">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negeri">Negeri: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'StateCd')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                                    'options' => [
                                        'multiple' => false
                                    ],
                                    'pluginOptions' => [
                                        'placeholder' => 'Pilih Negeri',
                                        'depends' => [Html::getInputId($model, 'CountryCd')],
                                        'initialize' => true,
                                        'url' => Url::to(['/alamat/statelist'])
                                    ]
                                ])->label(false)
                            ?>
                        </div>
                    </div>

                    <div class="form-group" id="daerah">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Daerah: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'CityCd')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'data' => ArrayHelper::map(Bandar::find()->all(), 'CityCd', 'City'),
                                    'options' => [
                                        'multiple' => false,
                                    ],
                                    'pluginOptions' => [
                                        'placeholder' => 'Pilih Bandar',
                                        'depends' => [Html::getInputId($model, 'StateCd')],
                                        'initialize' => true,
                                        'url' => Url::to(['/alamat/citylist'])
                                    ]
                                ])->label(false)
                            ?>
                        </div>
                    </div>

                    <div class="form-group" id="poskod">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Poskod">Poskod: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'Postcode')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoTel">NO. Telefon: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'TelNo')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                    </div>


                </div>
                <div class="form-group text-center">
                    <?= \yii\helpers\Html::a('Kembali', ['view'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>