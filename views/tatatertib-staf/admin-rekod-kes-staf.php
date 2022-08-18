<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Url;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;
use dosamigos\datepicker\DatePicker;
use kartik\editors\Summernote;
$this->title = 'Rekod Kes Kakitangan';
?>
<div class="x_panel">
             <p align="right"> 
         <?= Html::a('Kembali', ['tatatertib-staf/index'], ['class' => 'btn btn-primary btn-sm']) ?>
        </p>
    <div class="x_title">
        <h2><i class="fa fa-pencil"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <?= $form->errorSummary($model); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-user"></i>&nbsp;Nama Kakitangan: <span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <?=
                    $form->field($model, 'icno')->label(false)->widget(Select2::class, [
                        'data' => $dropdown_list_name,
                        'options' => ['placeholder' => '-- Select Staff --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => true,
                        ],
                        
                    ]);
                ?>
            </div>
        </div>
        
         <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-pencil"></i>&nbsp;Jenis Kesalahan (i): <span class="required" style="color:red;">*</span></label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                  <?=
                            $form->field($model, 'jenis_kesalahan')->label(false)->widget(Select2::classname(), [
                            'data' => [1=>'Tidak Hadir Bertugas', 2 =>'Pelanggaran Peraturan Kewangan & Perakuan Universiti', 3 => 'Telah melanggar Keputusan Lembaga Pengarah Universiti'],
                            'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                  ?>
            </div>
        </div>
        
    
        <div class="form-group">
               <label class="col-sm-3 control-label"><i class="fa fa-book"></i>&nbsp;Pelanggaran Tatakelakuan Yang Disabitkan (ii: <span class="required" style="color:red;">*</span></label>        
               <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                  echo $form->field($model, 'kes')->widget(Summernote::class, [
                  'useKrajeePresets' => true,           
                   ])->label(false);    
                  ?>
                </div>
        </div>
        
        
        
             

        
           <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank">Tarikh Aduan Diterima: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_aduan',
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
               <label class="col-sm-3 control-label"><i class="fa fa-book"></i>&nbsp;Dokumen:<span class="required" style="color:red;">*</span></label>        
               <div class="col-md-6 col-sm-6 col-xs-12">
                  <?= $form->field($model, 'file')->fileInput()->label(false);?>
                </div>
        </div>
        
        


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['tatatertib-staf/index'], ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-down"></i>&nbsp;Masukkan ke Senarai Rekod Kes', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
       
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong>Senarai Rekod</strong></h2>

                <ul class="nav navbar-right panel_toolbox ">

                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Select</th>
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jenis Kesalahan</th>
                                <th class="text-center">Pelanggaran Tatakelakuan Yang Disabitkan</th>
                                <th class="text-center">Dokumen</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <?php if ($kes_list) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form-1',
                                'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons'],
                            ])
                            ?>
                            <?php foreach ($kes_list as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $form->field($v, 'id[]')->checkbox(['value' => $v->id, 'label' => '', 'class' => 'checkId']); ?></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                    <td><strong><?= $v->kakitangan->CONm ?></strong></td>
                                    <td><strong><?= $v->jenisKesalahan->kesalahan_nm ?></strong></td>
                                    <td><strong><?= $v->kes ?></strong></td>

                                    
                                    <td> <?php
                                    if ($v->file) { ?>
                                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                                                             href="<?= Url::to(Yii::$app->FileManager->DisplayFile($model->file), true); ?>" target="_blank" >
                                                        <i class="fa fa-download"></i> <strong><small><u>MUAT TURUN DOKUMEN</small></u></strong></a><br>
                                         <?php } else {
                                        echo '<i>Tiada Maklumat</i>'.'<br>';
                                        } ?> 
                                    </td>
                                    
                                   <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-paper-plane"></i>&nbsp;Padam', ['tatatertib-staf/delete-rekod-kes', 'id' => $v->id], [
                                          'class' => 'btn btn-success btn-sm',
                                           'data' => [
                                           'confirm' => 'Anda Pasti untuk memadam data ini?',
                                            'method' => 'post',
                                          ],
                                   ]); ?></td>
                                                                        
                                </tr>
                            <?php } ?>
                            <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>
                            <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Padam', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });

JS;
$this->registerJs($script, View::POS_END);
?>