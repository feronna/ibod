<?php

use yii\helpers\Html;
use kartik\form\ActiveForm; 
?> 
<?php echo $this->render('menu'); ?> 

<div class="x_panel">
    <div class="x_title">
        <h2 >MAKLUMAT CALON</h2>
        <div class="clearfix"></div>
    </div> 
    <div class="table-responsive">
        <center>
            <div class="profile_img">
                <div id="crop-avatar"> <br/>
                    <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
                </div>
            </div>
            <br/>
            <table class="table table-sm table-bordered jambo_table table-striped" style="width:60%"> 
                <tr>   
                    <th style="width:40%">GELARAN</th>  
                    <td><?= $biodata->gelaran->Title; ?></td> 
                </tr> 
                <tr>   
                    <th>NAMA</th>  
                    <td><?= $biodata->CONm; ?></td> 
                </tr>
                <tr>   
                    <th>UMSPER</th>  
                    <td><?= $biodata->COOldID; ?></td> 
                </tr>
                <tr>   
                    <th>JAWATAN</th>  
                    <td><?= $biodata->jawatan->fname; ?></td> 
                </tr>
                <tr>   
                    <th>JFPIU SEMASA</th>  
                    <td><?= $biodata->penempatan ? $biodata->penempatan->department->fullname : ' ' ?></td> 
                </tr>
                <tr>   
                    <th>KAMPUS SEMASA</th>  
                    <td><?= $biodata->campus_id ? $biodata->kampus->campus_name : ''; ?></td> 
                </tr>
                <tr>   
                    <th>JFPIU HAKIKI</th>  
                    <td><?= $biodata->DeptId_hakiki ? $biodata->department->fullname : ' ' ?></td> 
                </tr>
                <tr>   
                    <th>UMUR</th>  
                    <td><?= date("Y") - date("Y", strtotime($biodata->COBirthDt)); ?></td> 
                </tr>
                <tr>   
                    <th>TEMPOH PERKHIDMATAN KESELURUHAN</th>  
                    <td><?= $biodata->servPeriodPermanent; ?></td> 
                </tr>
                <tr>   
                    <th>TEMPOH PERKHIDMATAN JAWATAN SEMASA</th>  
                    <td><?= $biodata->servPeriodCPosition; ?></td> 
                </tr>
                <tr>   
                    <th>TARIKH LANTIKAN JAWATAN SEMASA</th>  
                    <td><?php
                        if ($biodata->statLantikan == 1) {//tetap
                            echo $biodata->sandangan ? $biodata->sandangan->tarikhMulaSandangan : '-';
                        } else {
                            echo '-';
                        }
                        ?></td> 
                </tr>
            </table>
        </center>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2>STATUS PERAKUAN</h2>
        <div class="clearfix"></div>
    </div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
<div class="x_content">  
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
            <?= $form->field($model, 'admin_status')->radioList(array('1' => 'Diluluskan', 2 => 'Ditolak'))->label(false); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">  
            <?= $form->field($model, 'admin_ulasan')->textarea(['rows' => 6])->label(false);?>
        </div>  
    </div> 
    <div class="hide">  
            <?= $form->field($model, 'admin_datetime')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
            <?= $form->field($model, 'admin_ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
        <?= $form->field($model, 'status_id')->hiddenInput(['value' => 3])->label(false); ?>  
        </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?> 
</div>
</div>   
</div>  
