<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
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
                        <th class="col-md-2 col-sm-2 col-xs-12">Nama Pegawai</th> 
                        <th class="col-md-2 col-sm-2 col-xs-12">No. Kad Pengenalan</th> 
                        <th class="col-md-2 col-sm-2 col-xs-12">Jawatan</th> 
                        <th class="col-md-2 col-sm-2 col-xs-12">Jabatan</th> 
                        <th class="col-md-2 col-sm-2 col-xs-12">Tarikh Bertugas</th> 
                        <th class="col-md-2 col-sm-2 col-xs-12">Senarai Tugas</th> 
                    </tr> 
                    
                    <?php $bil=1; foreach($model as $model){ ?>
                    <tr>  
                        <td><?= $model->biodata->displayGelaran . ' ' . ucwords(strtolower($model->biodata->CONm)); ?></td>  
                        <td><?php
                            if ($model->biodata->NatCd == "MYS") {
                                echo $model->biodata->ICNO;
                            } else {
                                echo $model->biodata->latestPaspot;
                            }
                            ?></td>  
                        <td><?= $model->biodata->jawatan->nama; ?> (<?= $model->biodata->jawatan->gred; ?>)</td>  
                        <td><?= $model->biodata->department->fullname; ?></td>  
                        <td><?= $model->biodata->getTarikh($model->StartDate).' - '.$model->biodata->getTarikh($model->EndDate);?></td> 
                        <td><?= $model->tugas; ?></td> 
                    </tr> 
                    <?php } ?>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($permohonan, 'approved_bsm_ulasan')->textarea(['rows'=>6])->label(false);
                    ?> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?= $form->field($permohonan, 'approved_bsm_status')->radioList(array('1'=>'LULUS',2=>'DITOLAK'))->label(false); ?>
                </div>
            </div>
            <div class="hide">  
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

