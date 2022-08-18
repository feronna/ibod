<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\TblSelfhealth;
use app\models\kehadiran\TblWfh;

error_reporting(0);
?>
<?= $this->render('_topmenu') ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_content">
                <?php
                $forms = ActiveForm::begin([
                            'action' => [''],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <div class="form-group">
                      <div class="col-md-2 col-sm-2 col-xs-6">
                        <?=  Select2::widget([
                            'name' => 'jfpib',
                            'value' => $jfpib,
                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
                            'options' => ['placeholder' => 'JFPIB'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                ?>
                    </div>
                </div>
                
<!--                <div class="form-group">
                      <div class="col-md-2 col-sm-2 col-xs-6">
                        <?=  Select2::widget([
                            'name' => 'category',
                            'value' => $category,
                            'data' => [1 => 'Academic', 2 => 'Administration'],
                            'options' => ['placeholder' => 'Job category'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                ?>
                    </div>
                </div>-->
                
                <div class="form-group">
                      <div class="col-md-2 col-sm-2 col-xs-6">
                        <?=  DatePicker::widget([
                        'name' => 'date',
                        'value' => $date,
                        'type' => DatePicker::TYPE_INPUT,
                         'options' => ['placeholder' => $date? : 'From 17 JUN 2020','autocomplete' => 'off',
                                ],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'allowClear' => true,
                            'format' => 'd M yyyy',
                        ]
                    ]);?>
                    </div>
                </div>
                 
               
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row text-center">
    
    <?php 
    
            $date1 = date_format(date_create($date), 'Y-m-d');
            $office = count($wfo);
            $home = count($wfh);
            $all = count($listicno->all());
            $nonv = $all - $office - $home;?>
     <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="row">
                <div class="progress progress-mini">
                    <div style="width: <?= $office/$all*100?>%;color:black;" class="progress-bar bg-blue"><?= ' '.number_format($office/$all*100, 2).'%'?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-building"></i></div>
            <div style="font-size: 40px;">
                
            <?= $office?>
            </div>
            <div style="font-size: 12px;">
            Total number of staff (Work from office)
            </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '1');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '2');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '3');
                        }))?></li>
                <li>Kudat : <?= count(array_filter($dwfo, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '4');
                        }))?></li>
                 <li>Keningau : <?= count(array_filter($dwfo, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '5');
                        }))?></li>
                 <li>Tawau : <?= count(array_filter($dwfo, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '6');
                        }))?></li>
            </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="row">
            <div class="progress progress-mini">
                <div style="width: <?= $home/$all*100?>%;color:black;" class="progress-bar bg-blue"><?= ' '.number_format($home/$all*100, 2).'%'?>
                    </div>
            </div></div>
            
            <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-home"></i></div>
            <div style="font-size: 40px;">
            <?= $home;?>
            </div>
            <div style="font-size: 12px;">
            Total number of staff (Work from home)
            </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($wfh, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '1');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($wfh, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '2');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($wfh, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '3');
                        }))?></li>
                 <li>Kudat : <?= count(array_filter($wfh, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '4');
                        }))?></li>
                 <li>Keningau : <?= count(array_filter($wfh, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '5');
                        }))?></li>
                  <li>Tawau : <?= count(array_filter($wfh, function ($var) {
                        return ($var['kakitangan']['campus_id'] == '6');
                        }))?></li>
            </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="row">
                <div class="progress progress-mini">
                    <div style="width: <?= $nonv/$all*100?>%;color:black;" class="progress-bar bg-blue"><?= ' '.number_format($nonv/$all*100, 2).'%'?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-home"></i></div>
            <div style="font-size: 40px;">
                
            <?= $nonv?>
            </div>
            <div style="font-size: 12px;">
            Total number of staff (Work from office - Haven't clocked in)
            </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($non, function ($var) {
                        return ($var['campus_id'] == '1');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($non, function ($var) {
                        return ($var['campus_id'] == '2');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($non, function ($var) {
                        return ($var['campus_id'] == '3');
                        }))?></li>
                 <li>Kudat : <?= count(array_filter($non, function ($var) {
                        return ($var['campus_id'] == '4');
                        }))?></li>
                  <li>Keningau : <?= count(array_filter($non, function ($var) {
                        return ($var['campus_id'] == '5');
                        }))?></li>
                   <li>Tawau : <?= count(array_filter($non, function ($var) {
                        return ($var['campus_id'] == '6');
                        }))?></li>
            </ul>
            </div>
        </div>
    </div>


<div class="row text-center">
<div class="col-md-4 col-sm-4 col-xs-12" ><i style="font-size: 20px;" class="fa fa-hand-o-down"></i></div>
</div><br>
<?php $sick = count(array_filter($dwfo, function ($var) {
            return ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5));
        }))?>
<div class="row text-center">
    <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel" style="height: 295px;"><br>
        <div class="row">
        <div class="progress progress-mini">
                <div style="width: <?= $sick/$office*100?>%;color:black;" class="progress-bar bg-red"><?= ' '.number_format($sick/$office*100, 2).'%'?></div>
        </div></div>
        
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-warning"></i></div>
            <div style="font-size: 40px;">

            <?= $sick?>
            </div>
            <div style="font-size: 12px;">
            Total number of symptomatic staff (Work from office)
            </div>
        </div>
        
        <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' &&  ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' &&  ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' &&  ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
                        }))?></li>
            </ul>
            </div>
    </div>
    </div>
    
    <?php $sick1 = count(array_filter($dwfo, function ($var) {
                return ( ($var['health_status'] == 2 && !($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
            }))?>
    
    <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="row">
            <div class="progress progress-mini">
                <div style="width: <?= $sick1/$sick*100?>%;color:black;" class="progress-bar bg-orange"><?= ' '.number_format($sick1/$sick*100, 2).'%'?></div>
            </div></div>
        
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 40px;">
            <?= $sick1;?>
            </div>
            <div style="font-size: 12px;">
            Only have symptoms fever, cough, or shortness of breath
            </div></div>
        
        <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' &&  ($var['health_status'] == 2 && !($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' &&  ($var['health_status'] == 2 && !($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' &&  ($var['health_status'] == 2 && !($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)));
                        }))?></li>
            </ul>
            </div>
    </div>
        <div class="x_panel">
            <?php $sick2 = count(array_filter($dwfo, function ($var) {
                return ( ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5));
            }))?>
            <div class="row">
            <div class="progress progress-mini">
                <div style="width: <?= $sick2/$sick*100?>%;color:black;" class="progress-bar bg-orange"><?= ' '.number_format($sick2/$sick*100, 2).'%'?></div>
            </div></div>
            
            <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 40px;">
            <?= $sick2;?>
            </div>
            <div style="font-size: 12px;">
            Temperature above or equal to 37.5 °C
            </div>
            </div>
        
        <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' &&  ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5));
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' &&  ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5));
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' &&  ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5));
                        }))?></li>
            </ul>
            </div>
        </div>       
    </div>
</div>

<div class="row text-center">
<div class="col-md-6 col-sm-6 col-xs-6" ><i style="font-size: 20px;" class="fa fa-hand-o-down"></i></div>
</div><br>

<div class="row text-center">
    <div class="x_panel">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-suitcase"></i></div> Permission to work</div><br>
        <div class="col-md-4 col-sm-4 col-xs-12"> 
            <div class="x_panel">
                <?php $work1 = count(array_filter($dwfo, function ($var) {
                return ( ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == '');
            }))?>
                <div class="row">
                <div class="progress progress-mini">
                <div style="width: <?= $work1/$sick*100?>%;color:black;" class="progress-bar bg-green"><?= ' '.number_format($work1/$sick*100, 2).'%'?></div>
                </div></div>
             
            <div class="col-md-6 col-sm-6 col-xs-6" >
            <div style="font-size: 25px; color: #7367F0"></div>
            <div style="font-size: 40px;">
            <?= $work1;?>
            </div>
            <div style="font-size: 12px;">
            Pending
            </div>
            </div>
                
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <?php 
                    ?>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' &&  ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == '');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' &&  ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == '');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' &&  ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == '');
                        }))?></li>
            </ul>
            </div>   
            </div>
        </div>
        
        <div class="col-md-4 col-sm-4 col-xs-12"> 
            <div class="x_panel">
                <?php $work2 = count(array_filter($dwfo, function ($var) {
                return ( ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Allow to work');
            }))?>
                <div class="row">
                <div class="progress progress-mini">
                <div style="width: <?= $work2/$sick*100?>%;color:black;" class="progress-bar bg-green"><?= ' '.number_format($work2/$sick*100, 2).'%'?></div>
                </div></div>
                
            <div class="col-md-6 col-sm-6 col-xs-6" > 
            <div style="font-size: 25px; color: #7367F0"></div>
            <div style="font-size: 40px;">
            <?= $work2?>
            </div>
            <div style="font-size: 12px;">
            Allowed to work
            </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' && ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Allow to work');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' && ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Allow to work');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' && ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Allow to work');
                        }))?></li>
            </ul>
            </div>    
            </div>
        </div>
        
        <div class="col-md-4 col-sm-4 col-xs-12"> 
            <div class="x_panel">
                <?php $work3 = count(array_filter($dwfo, function ($var) {
            return ( ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Not allow to work');
            }))?>
                <div class="row">
                <div class="progress progress-mini">
                <div style="width: <?= $work3/$sick*100?>%;color:black;" class="progress-bar bg-green"><?= ' '.number_format($work3/$sick*100, 2).'%'?></div>
                </div></div>
                
            <div class="col-md-6 col-sm-6 col-xs-6" >   
            <div style="font-size: 25px; color: #7367F0"></div>
            <div style="font-size: 40px;">
            <?= $work3?>
            </div>
            <div style="font-size: 12px;">
            Not allowed to work
            </div>
            </div>
                
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == 1 && ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Not allow to work');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == 2 && ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Not allow to work');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == 3 && ($var['health_status'] == 2 || ($var['temperature'] == '> 37.5' || $var['temperature'] > 37.5)) && $var['status_prw'] == 'Not allow to work');
                        }))?></li>
            </ul>
            </div> 
            </div>
        </div>
            
        
    </div>
</div>

<div class="row text-center">
    <div class="x_panel">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-hospital-o"></i></div> Clinic for treatment</div><br>
        <div class="col-md-6 col-sm-6 col-xs-12"> 
            <div class="x_panel">
                <?php $clinic1= count(array_filter($dwfo, function ($var) {
                return ($var['treatment_place'] == 'prw');
            }))?>
<!--                <div class="row">
                <div class="progress progress-mini">
                <div style="width: <?= $work1/$sick*100?>%;color:black;" class="progress-bar bg-green"><?= ' '.number_format($work1/$sick*100, 2).'%'?></div>
                </div>
                </div>-->
             
            <div class="col-md-6 col-sm-6 col-xs-6" >
            <div style="font-size: 25px; color: #7367F0"></div>
            <div style="font-size: 40px;">
            <?= $clinic1;?>
            </div>
            <div style="font-size: 12px;">
            PRW / Klinik Rawatan UMS
            </div>
            </div>
                
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <?php 
                    ?>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' && $var['treatment_place'] == 'prw');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' && $var['treatment_place'] == 'prw');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' && $var['treatment_place'] == 'prw');
                        }))?></li>
            </ul>
            </div>   
            </div>
        </div>
        
        <div class="col-md-6 col-sm-6 col-xs-12"> 
            <div class="x_panel">
                <?php $clinic2 = count(array_filter($dwfo, function ($var) {
                return ($var['treatment_place'] == 'lain-lain');
            }))?>
<!--                <div class="row">
                <div class="progress progress-mini">
                <div style="width: <?= $work2/$sick*100?>%;color:black;" class="progress-bar bg-green"><?= ' '.number_format($work2/$sick*100, 2).'%'?></div>
                </div></div>-->
                
            <div class="col-md-6 col-sm-6 col-xs-6" > 
            <div style="font-size: 25px; color: #7367F0"></div>
            <div style="font-size: 40px;">
            <?= $clinic2?>
            </div>
            <div style="font-size: 12px;">
            Klinik Panel UMS / Hospital / Lain-lain klinik
            </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6 text-left">
                <ul>
                    <li>Kota Kinabalu : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '1' && $var['treatment_place'] == 'lain-lain');
                        }))?></li>
                <li>Labuan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '2' && $var['treatment_place'] == 'lain-lain');
                        }))?></li>
                <li>Sandakan : <?= count(array_filter($dwfo, function ($var) {
                            return ($var['kakitangan']['campus_id'] == '3' && $var['treatment_place'] == 'lain-lain');
                        }))?></li>
            </ul>
            </div>    
            </div>
        </div>
            
        
    </div>
</div>