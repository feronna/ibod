<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>   
<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

    <?php if ($biodata) { ?>
        <div class="x_panel"> 
            <div class="x_title">
                <h2>Maklumat Pegawai</h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <tr>
                            <th rowspan="7" class="col-md-3 col-sm-3 col-xs-12">
                        <div class="profile_img">
                            <div id="crop-avatar"> <br/>
                                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
                            </div>
                        </div>
                        </th> 
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $biodata->gelaran->Title . " " . ucwords(strtolower($biodata->CONm)); ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                            <td><?= $biodata->ICNO; ?></td> 
                        </tr>  
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">UMSPER</th>
                            <td><?= $biodata->COOldID; ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                            <td><?= $biodata->department->fullname; ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                            <td><?= $biodata->jawatan->nama; ?> (<?= $biodata->jawatan->gred; ?>)</td> 
                        </tr> 

                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Kampus</th>
                            <td><?= $biodata->kampus->campus_name; ?> </td> 
                        </tr> 

                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Ketua Jabatan</th>
                            <td><?php
                                if ($biodata->department->chief == $biodata->ICNO) {
                                    echo 'Taufiq Yap Yun Hin';
                                } else {
                                    echo $biodata->department ? ucwords(strtolower($biodata->department->k_jabatan->CONm)) : 'Tiada Maklumat';
                                }
                                ?></td> 
                        </tr>
                    </table>
                </div> 
            </div>
        </div>
    <?php } ?>

<div class="x_panel"> 
    <div class="x_title">
        <h2><center><strong><h2>Kemaskini Permohonan</h2></strong></center><br/><br/>  </h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh bertugas: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">  
                <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'StartDate',
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
            <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>  
    </div>
</div>