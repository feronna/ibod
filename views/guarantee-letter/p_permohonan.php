<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Peribadi</h2> <p align="right"><?= Html::a('Manual Pengguna', ['manual-pengguna'], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $model->displayGelaran . ' ' . ucwords(strtolower($model->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?php
                            if ($model->NatCd == "MYS") {
                                echo $model->ICNO;
                            } else {
                                echo $model->latestPaspot? $model->latestPaspot:'<span class="required" style="color:red;"><b>Tiada Maklumat - Sila Kemaskini Maklumat Passport Anda </b>'.Html::a('disini', ['pasport-permit/view'],['class' => 'btn btn-warning btn-sm']). '</span>';
                            }
                            ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gred Gaji</th>
                        <td><?= $model->jawatan->gred; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gaji Pokok</th>
                        <td><?= $model->gajiBasic; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $model->jawatan->nama; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Kelayakan Kelas Wad</th>
                        <td><?= ucwords(strtolower($permohonan->kelasWad->nama)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Alamat Pejabat</th>
                        <td>
                            <?= $model->department->fullname; ?>,
                            Universiti Malaysia Sabah,
                            <?php
                            if ($model->campus_id == 1) {
                                echo " Jalan Universiti Malaysia Sabah, 88400 Kota Kinabalu.";
                            } else if ($model->campus_id == 2) {
                                echo " Labuan International Campus, Jln. Sungai Pagar, 87000 Labuan.";
                            } else if ($model->campus_id == 3) {
                                echo " Locked Bag No. 3, 90509 Sandakan.";
                            }
                            ?>
                        </td> 
                    </tr>  
                </table>
            </div> 

        </div>
    </div>

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Butiran Permohonan</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Hospital: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($permohonan, 'gl_hospital_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\guarantee_letter\TblHospital::find()->all(), 'id', 'nama'),
                        'options' => ['placeholder' => 'Pilih Hospital'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?> 
                </div>
            </div>
            <?php if ($model->NatCd == "MYS") { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pemohon:
                    </label>


                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($permohonan, 'gl_ICNO')->label(false)->widget(Select2::classname(), [
                            'data' => ['1' => 'DIRI SENDIRI', '2' => 'TANGGUNGAN'],
                            'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript:if ($(this).val() == "2"){ $("#tanggungan").show();}
                    else{$("#tanggungan").hide();}'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12" id="tanggungan" style="display:none">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggungan:
                        </label>


                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($permohonan, 'family')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map($queryKeluarga, 'FamilyId', 'UpperCase'),
                                'options' => ['placeholder' => 'Pilih'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false);
                            ?>  
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Mohon', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

