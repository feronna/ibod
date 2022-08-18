<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
?> 
<?php echo $this->render('menu'); ?> 

<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">CANDIDATE INFORMATION</p> 
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
                    <th style="width:40%">Title</th>  
                    <td><?= $biodata->gelaran->Title; ?></td> 
                </tr> 
                <tr>   
                    <th>Name</th>  
                    <td><?= $biodata->CONm; ?></td> 
                </tr>
                <tr>   
                    <th>Umsper</th>  
                    <td><?= $biodata->COOldID; ?></td> 
                </tr>
                <tr>   
                    <th>Current Position</th>  
                    <td><?= $biodata->jawatan->fname; ?></td> 
                </tr>
                <tr>   
                    <th>Department</th>  
                    <td><?= $biodata->penempatan ? $biodata->penempatan->department->fullname : ' ' ?></td> 
                </tr>
                <tr>   
                    <th>Campus</th>  
                    <td><?= $biodata->campus_id ? $biodata->kampus->campus_name : ''; ?></td> 
                </tr>
                <?php if ($model->svc($model->current_gred) == 1) { ?>
                    <tr>   
                        <th>Department (Actual)</th>  
                        <td><?= $biodata->departmentHakiki ? $biodata->departmentHakiki->fullname : ' ' ?></td> 
                    </tr>
                <?php } else { ?>
                    <tr>   
                        <th>Department</th>  
                        <td><?= $biodata->department ? $biodata->department->fullname : ' ' ?></td> 
                    </tr>
                <?php } ?>
                <tr>   
                    <th>Age</th>  
                    <td><?= date("Y") - date("Y", strtotime($biodata->COBirthDt)); ?></td> 
                </tr>
                <tr>   
                    <th>Period of service (UMS)</th>  
                    <td><?= $biodata->servPeriodPermanentBI; ?></td> 
                </tr>
                <?php if ($biodata->statLantikan == 1) { ?>
                    <tr>   
                        <th>Appointed to current position period</th>  
                        <td><?= $biodata->servPeriodCPositionBI; ?></td> 
                    </tr>
                <?php } ?>
                <tr>   
                    <th>Date Assigned to current position</th>  
                    <td><?php
                        if ($biodata->statLantikan == 1) {//tetap
                            echo $biodata->sandangan ? $biodata->getTarikhBI($biodata->sandangan->start_date) : '-';
                        } else {
                            echo $biodata->sandanganCKontrak ? $biodata->getTarikhBI($biodata->sandanganCKontrak->start_date) : '-';
                        }
                        ?></td> 
                </tr>
            </table>
        </center>
    </div>
</div>


<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">APPROVAL STATUS</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'kj_status')->radioList(array('1' => 'Approve', 2 => 'Reject'))->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">  
                <?= $form->field($model, 'kj_ulasan')->textarea(['rows' => 6])->label(false); ?>
            </div>  
        </div> 
        <div class="hide">  
            <?= $form->field($model, 'kj_datetime')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
            <?= $form->field($model, 'kj_ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
            <?= $form->field($model, 'status_id')->hiddenInput(['value' => 2])->label(false); ?>  
        </div>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Cancel', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div>   
</div>  
