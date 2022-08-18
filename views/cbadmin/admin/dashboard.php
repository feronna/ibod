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
    
                    $date1 = date_format(date_create($date), 'yy-m-d');
                    $office = count(array_filter($model, function ($var) {
                        return ($var['status'] == 'Work from office');
                        }));
                    $home = ($date1 >= '2020-06-24')? TblSelfhealth::totalWfh($date1, '', $jfpib):count(array_filter($model, function ($var) {
                        return ($var['status'] == 'Work from home');
                        }));
           $all = count($biodata);?>
     <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="row">
                <div class="progress progress-mini">
                    <div style="width: <?= $office/$all*100?>%;color:black;" class="progress-bar bg-blue"><?= ' '.number_format($office/$all*100, 2).'%'?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-graduation-cap"></i></div>
            <div style="font-size: 40px;">
                
            <?= $office?>
            </div>
            <div style="font-size: 12px;">
                Jumlah Kakitangan Akademik <br> Yang Sedang Cuti Belajar
            </div>
            </div>
            
            
        </div>
    </div>
    
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="row">
            <div class="progress progress-mini">
                <div style="width: <?= $home/$all*100?>%;color:black;" class="progress-bar bg-blue"><?= ' '.number_format($home/$all*100, 2).'%'?>
                    </div>
            </div></div>
            
            <div class="col-md-6 col-sm-6 col-xs-6">
            <div style="font-size: 25px; color: #7367F0"><b><i class="fa fa-users"></i></div>
            <div style="font-size: 40px;">
            <?= $home;?>
            </div>
            <div style="font-size: 12px;">
                Jumlah Kakitangan Pentadbiran <br> Yang Sedang Cuti Belajar
            </div>
            </div>
            
           
        </div>
    </div>
</div>





