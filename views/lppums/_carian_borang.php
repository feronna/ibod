<?php

$js = <<<js
    $(document).ready(function(){
        
        $(".nama").hide();
        $(".jspiu").hide();
        $(".tahun2").hide();
        
        var val1 = $("#jenis_carian").val();
        switch(parseInt(val1)) {
            case 2:
                $(".jspiu").show();
                $(".nama").hide();
                $(".tahun2").show();
                break;
            case 3:
                $(".jspiu").hide();
                $(".nama").show();
                $(".tahun2").show();
                break;
            case 1:
                $(".jspiu").hide();
                $(".nama").hide();
                $(".tahun2").show();
                break;
        }
        
        $('#jenis_carian').on('select2:close', function(e) {
            
            var val = $('#jenis_carian').val();
            
            switch(parseInt(val)) {
                case 2:
                   $(':input').not(":button").val('');
                   $("#tahun").val(1).trigger('change');
                   $(".jspiu").show();
                   $(".nama").hide();
                   $(".tahun2").show();
                   break;
                case 3:
                   $("#senarai").val('').trigger('change');
                   $("#tahun").val(1).trigger('change');
                   $(".jspiu").hide();
                   $(".nama").show();
                   $(".tahun2").show();
                   break; 
                case 1:
                   $("#senarai").val('').trigger('change');
                   $("#tahun").val('').trigger('change');
                   $(':input').not(":button").val('');
                   $(".jspiu").hide();
                   $(".nama").hide();
                   $(".tahun2").show();
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
use app\models\lppums\TblLppTahun;
use yii\db\Expression;

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
                <h2><strong><?= $title; ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['action' => $tmp, 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis_carian">Jenis Carian</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?=
                            $form->field($model, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                                'data' => [1 => "Rekod Sendiri", 2 => "Senarai JAFPIB", 3 => "Carian Nama / No. KP / Passport"],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Rekod',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'id' => 'jenis_carian',
                                ],
                                'pluginOptions' => [],
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

                    <div class="form-group nama">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PPP
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($model, 'PPP')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                    ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                    ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                    ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'options' => [
                                    'placeholder' => 'Pilih Pegawai',
                                    'class' => 'form-control col-md-7 col-xs-12',

                                    'id' => 'ppp',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group nama">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PPK
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($model, 'PPK')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                    ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                    ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                    ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'options' => [
                                    'placeholder' => 'Pilih Pegawai',
                                    'class' => 'form-control col-md-7 col-xs-12',

                                    'id' => 'ppk',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group nama">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PP
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($model, 'PP_ALL')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                    ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                    ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                    ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'options' => [
                                    'placeholder' => 'Pilih Pegawai',
                                    'class' => 'form-control col-md-7 col-xs-12',

                                    'id' => 'pp',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
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

                                    'id' => 'senarai',
                                ],
                                'pluginOptions' => [

                                    'disabled' => (($this->context->action->id == 'penetap-pegawai-penilai' || $this->context->action->id == 'penetap-markah-borang') ? true : false)
                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group tahun2">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Tahun Penilaian</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'id' => 'tahun',
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