<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;


$this->title = 'Jabatan';
?>
<div class="gelaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="gelaran-form">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="x_panel">
            <div class="x_title">
                <h2><?= "Tambah/Kemaskini Jabatan" ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh Jabatan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Singkatan Jabatan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'shortname')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'chief')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=','status','6'])->All(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => 'Pilih Ketua Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Pendaftar<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'pp')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=','status','6'])->All(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => 'Pilih Ketua Pentadbiran', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Jabatan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'address')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Fax<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'fax_no')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tel_no')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. UC<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'uc_no')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">P.A. Email<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'pa_email')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Jabatan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'dept_cat_id')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(\app\models\hronline\DeptCat::find()->all(), 'id', 'category'),
                                'options' => ['placeholder' => 'Pilih Kategori Department', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Daripada Jabatan<span class="required" style="color:red;"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'sub_of')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()->all(), 'id', 'fullname'),
                                'options' => ['placeholder' => 'Pilih Sub Daripada Department', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'isActive')->checkbox(['label' => 'Tandakan jika aktif', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">MyMohesCd ( KOD Jabatan )<span class="required" style="color:red;"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'mymohesCd')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Cluster<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($model, 'cluster')->label(false)->widget(Select2::classname(), [
                                'data' => ["1"=>"Science & Tech","2"=>"Science","3"=>"Clinical"],
                                'options' => ['placeholder' => 'Pilih klaster', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>