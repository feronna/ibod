<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
error_reporting(0);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
            if($('#form').prop('name') === 'isikpi'){
                location.reload();
            }
        $('#modalContent').empty();
        $("html").css({"overflow":"auto"});
  });
  $("#mod").on('hidden.bs.modal', function(){
         $('#modal').find('#modalContent')
               .load('isikpi');
       $("html").css({"overflow":"hidden"});
       $('#modal').css({"overflow":"auto"});
  });
    });
</script>
<style>
    .tile-stats .count{
        font-size:26px;
        line-height:normal;
        height: 100px;
    }
    .tile-stats{
        height: 150px;
    }
    h3{
        font-size:14px;line-height: normal;
    }
    p{
        color:red;
    }
    thead{
        background-color: #495869;
        color: white;
        
    }
    
</style>
<?= $this->render('/kontrak/_topmenu') ?>
<?= $this->render('_inquiry') ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>APPLICATION FOR CONTRACT EXTENSION FORM [ACADEMIC STAFF]</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        
    <div class="row"> 
            <div class="x_panel">
                <div class="x_content">
                    <div class="col-xs-12 col-md-4">
                    <?php
                    $testingPage1 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        //'icon' => 'fas fa-chart-pie',
                                        'header' => 'Information taken from SMP & eLNPT',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'text' => $inteaching,
                                        'number' => 'Teaching<br> & <br>Learning',
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage1.'</a>', ['id' => 'modalButton', 'value' => 'coteaching?id='.$model->id,'style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>
                </div>
                    <div class="col-xs-12 col-md-4">
                    <?php
                    $testingPage2 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        //'icon' => 'fas fa-chart-pie',
                                        'header' => 'Information taken from SMP-PPI',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'number' => '<br>Research',
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage2.'</a>', ['id' => 'modalButton', 'value' => 'maklumatakademik?title=penyelidikan&id='.$model->id,'style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>  
                </div>
                    <div class="col-xs-12 col-md-4">
                    <?php
                    $testingPage3 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        //'icon' => 'fas fa-chart-pie',
                                        'header' => 'Information taken from SMP-PPI',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'number' => '<br>Publication',
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage3.'</a>', ['id' => 'modalButton', 'value' => 'maklumatakademik?title=penerbitan&id='.$model->id,'style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>  
                </div>
                    <div class="col-xs-12 col-md-4">
                    <?php
                    $testingPage4 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        //'icon' => 'fas fa-chart-pie',
                                        'header' => 'Information taken from SMP-PPI',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'number' => '<br>Consultancy',
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage4.'</a>', ['id' => 'modalButton', 'value' => 'maklumatakademik?title=perundingan&id='.$model->id,'style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>  
                </div>
                    <div class="col-xs-12 col-md-4">
                    <?php
                    $testingPage5 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        //'icon' => 'fas fa-chart-pie',
                                        'header' => 'Information taken from SMP',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'number' => 'Postgraduate <br>Students<br> Supervision',
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage5.'</a>', ['id' => 'modalButton', 'value' => 'maklumatakademik?title=penyeliaan&id='.$model->id,'style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>  
                </div>
<!--                    <div class="col-xs-12 col-md-4">
                    <?php
                    $testingPage6 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Filled by applicant',
                                        //'icon' => 'fas fa-chart-pie',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'number' => 'Scopus & <br>Google<br> Scholar',
                                        'text' => $inhindex,
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage6.'</a>', ['id' => 'modalButton', 'value' => 'hindex','style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>  
                </div>-->
                    <div class="col-xs-12 col-md-4" id="kpi">
                    <?php
                    $testingPage7 = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Filled by applicant',
                                        //'icon' => 'fas fa-chart-pie',
                                        //'text' => '<p class="bg-primary">Kursus wajib universiti</p>',
                                        'number' => 'Targeted Key<br>Performance<br>Indicators(KPI)',
                                        'text' => $inkpi,
                                    ]
                    );
                     echo Html::button('<a>'.$testingPage7.'</a>', ['id' => 'modalButton', 'value' => 'isikpi','style'=>'background-color: transparent; 
                                    border: none; width: 100%; text-align:left;', 'class' => 'mapBtn']);
                    ?>  
                </div>
                </div>
            </div>
        </div>
        <br>
        
<!--        for edit-->
        <?php if($edit === 1){?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason For Extension<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php $model->scenario = 'bi';?>
                <?= $form->field($model, 'reason')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Supporting Document :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                <?php if($model->dokumen_sokongan!= NULL){?>
                        <a style="border:0;box-shadow: none;" href="<?= yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u><?= Yii::$app->FileManager->NameFile($model->dokumen_sokongan) ?></u></a>
                        <div style="color: green;">
                            this file will be replace if new file is uploaded</div>
                <?php }?><br>
                <?= $form->field($model, 'url')->textInput(['placeholder' => "link of document. Example : https://drive.google.com/file/d/1PUZetcEmlgMzEp4"])->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                You may upload supporting documents or share the link of your supporting documents. Examples: Recognition / Expertise License / Hospital or other records
            </div>
            </div>
        </div>
        <?php if($model->firstapp){?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $model->firstapp?> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" value="<?= $model->ketuaprogram?>" disabled="disabled">
            </div>
        </div><?php }?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $model->secondapp?> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" value="<?= $model->ketuajfpiu?>" disabled="disabled">
            </div>
        </div>
        <br>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 
                'data'=>['confirm'=>'Please ensure that the information on the application is accurate. The submitted application cannot be amended or updated. Proceed?']]) ?>
            </div>
        </div>
        <?php }
        else{
            echo $this->render('_maklumatpermohonan',['model' => $model]);
            
        }ActiveForm::end();?>
    </div>
    </div>





