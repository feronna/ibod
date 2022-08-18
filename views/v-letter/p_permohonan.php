<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
?>  
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
	
	 <div class="x_panel"> 
        <div class="x_title">
            <h2>Makluman Penting</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
			 <div class="form-group">     
				<ul><font color="red">
				<li>Surat pengesahan majikan ini hanya sebagai sokongan dalam urusan masuk ke Negeri Sabah sekiranya diminta oleh pihak berkuasa.</li>
				</font>
				</ul>
            </div>
        </div>
    </div> 

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Peribadi</h2> <div class="clearfix"></div>
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
                                echo $model->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= $model->jawatan->nama; ?> (<?= $model->jawatan->gred; ?>)</td> 
                    </tr> 
                </table>
            </div> 

        </div>
    </div>
    
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Tujuan Permohonan</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?= $form->field($permohonan, 'apply_type')->radioList(array('1'=>'INDIVIDU',2=>'KELUARGA'))->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tujuan Pengesahan Majikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($permohonan, 'tujuan')->textarea(['rows'=>6])->label(false);
                    ?> 
                </div>
            </div>
            <div class="hide"> 
                <?= $form->field($permohonan, 'ICNO')->hiddenInput(['value' => $model->ICNO])->label(false); ?>
                <?= $form->field($permohonan, 'tarikh_mohon')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'status_semasa')->hiddenInput(['value' => 2])->label(false); ?>
                <?= $form->field($permohonan, 'isActive')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'status_notifikasi')->hiddenInput(['value' => 1])->label(false); ?>
				
				<?= $form->field($permohonan, 'tarikh_notifikasi')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
				<?= $form->field($permohonan, 'approved_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
				<?= $form->field($permohonan, 'approved_by')->hiddenInput(['value' => 'SYSTEM'])->label(false); ?>
            </div>
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Mohon', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

