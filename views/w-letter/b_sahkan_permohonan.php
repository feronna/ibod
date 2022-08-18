<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Permohonan</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $permohonan->biodata->displayGelaran . ' ' . ucwords(strtolower($permohonan->biodata->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?php
                            if ($permohonan->biodata->NatCd == "MYS") {
                                echo $permohonan->biodata->ICNO;
                            } else {
                                echo $permohonan->biodata->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $permohonan->biodata->jawatan->nama; ?> (<?= $permohonan->biodata->jawatan->gred; ?>)</td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                        <td><?= $permohonan->biodata->department->fullname; ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Bertugas</th>
                        <td><?= $permohonan->biodata->getTarikh($permohonan->StartDate) . ' - ' . $permohonan->biodata->getTarikh($permohonan->EndDate); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Senarai Tugas</th>
                        <td><?= $permohonan->tugas; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Ulasan Ketua Jabatan</th>
                        <td><?= $permohonan->approved_kj_ulasan; ?></td> 
                    </tr>
                </table>
            </div> 

        </div>
    </div>

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Ulasan Permohonan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh bertugas:
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">  
                    <?=
                    DatePicker::widget([
                        'model' => $permohonan,
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($permohonan, 'approved_bsm_ulasan')->textarea(['rows' => 6])->label(false);
                    ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?= $form->field($permohonan, 'approved_bsm_status')->radioList(array('1' => 'LULUS', 2 => 'DITOLAK'))->label(false); ?>
                </div>
            </div>
            <div class="hide"> 
                <?= $form->field($permohonan, 'status_notifikasi')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'tarikh_notifikasi')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_bsm_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_bsm_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
            </div>
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

