<?php

$js=<<<js
    $(document).ready(function(){
        
        $(".nama").hide();
        $(".jspiu").hide();
        $(".pegawai2").hide();
        
        var val1 = $("#jenis_carian").val();
        switch(parseInt(val1)) {
            case 1:
                $(".jspiu").show();
                $(".nama").hide();
                $(".pegawai2").show();
                break;
            case 2:
                $(".jspiu").hide();
                $(".nama").show();
                $(".pegawai2").show();
                break;
        }
        
        $('#jenis_carian').on('select2:close', function(e) {
            
            var val = $('#jenis_carian').val();
            
            switch(parseInt(val)) {
                case 1:
                   $(':input').not(":button").val('');
                   $("#pegawai").val(1).trigger('change');
                   $(".jspiu").show();
                   $(".nama").hide();
                   $(".pegawai2").show();
                   break;
                case 2:
                   $("#senarai").val('').trigger('change');
                   $("#pegawai").val(1).trigger('change');
                   $(".jspiu").hide();
                   $(".nama").show();
                   $(".pegawai2").show();
                   break; 
                case 3:
                   $("#senarai").val('').trigger('change');
                   $("#pegawai").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".jspiu").hide();
                   $(".nama").hide();
                   $(".pegawai2").hide();
                   break; 
            }
        
            $('#jenis_carian').val(val);
        
        }); 
        
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Department;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Penetapan Akses Sistem</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['action' => ['penetapan-akses-sistem'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?> 
                        <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_carian">Jenis Carian</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <?=
                                    $form->field($model, 'jenis')->label(false)->widget(Select2::classname(), [
                                        'data' => [1 => "Senarai JAFPIB", 2 => "Carian Nama / No. KP / Passport", 3 => "Carian Semua Pegawai Dengan AKSES Sahaja"],
                                        'hideSearch' => true,
                                        'options' => ['placeholder' => 'Pilih Jenis Akses', 
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'id' => 'jenis_carian',],
                                        'pluginOptions' => [
                                            //'allowClear' => true
                                        ],
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group nama">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PYD
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                $form->field($model, 'CONm')->textInput(['id' => 'nama_pyd'])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="form-group nama">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kp_paspot">No. KP / Passport PYD
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                $form->field($model, 'ICNO')->textInput(['id' => 'kp_paspot'])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="form-group jspiu">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Senarai JAFPIB</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                    $form->field($model, 'DeptId')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'fullname'),
                                        'options' => [
                                            'placeholder' => 'Pilih Jabatan', 
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            //'selected'    => 2,
                                            'id' => 'senarai',
                                            ],
                                        'pluginOptions' => [
                                            //'allowClear' => true
                                        ],
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group pegawai2">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="akses">Pegawai</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                    $form->field($model, 'akses')->label(false)->widget(Select2::classname(), [
                                        'data' => [1 => "Semua", 2 => "Dengan Akses Sahaja", 3 => "Tanpa Akses Sahaja"],
                                        'hideSearch' => true,
                                        'options' => ['placeholder' => 'Pilih Jenis Akses', 
                                            'class' => 'form-control col-md-7 col-xs-12',
                                            'id' => 'pegawai',],
                                        'pluginOptions' => [
                                            //'allowClear' => true
                                        ],
                                    ]);
                                ?>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="pull-right">
                                <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>