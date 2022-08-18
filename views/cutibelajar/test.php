<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center"><u>Maklumat Pegawai</u></h3>
        </div>
        <div class="panel-body">
            <table class="table table-sm table-bordered">
                <tr>
                    <td><strong>Nama Pegawai</strong></td>
                    <td><?= $bio->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong>No. KP/Pasport</strong></td>
                    <td><?= $bio->ICNO; ?></td>
                </tr>
                <tr>
                    <td><strong>JSPIU</strong></td>
                    <td><?= $bio->department->fullname; ?></td>
                </tr>
                <tr>
                    <td><strong>Jawatan / Gred</strong></td>
                    <td><?= $bio->jawatan->nama; ?> / <?= $bio->jawatan->gred; ?></td>
                </tr>
                
                
            </table>
        </div>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center"><u>Maklumat Pengajian Lanjutan</u></h3>
        </div>
        <div class="panel-body">
            <table class="table table-sm table-bordered">
                <tr>
                    <td><strong>Peringkat Pengajian</strong></td>
                    <td><?= $model->HighestEduLevel; ?></td>
                </tr>
                <tr>
                    <td><strong>Institusi</strong></td>
                    <td><?= $model->InstNm; ?></td>
                </tr>
                <tr>
                    <td><strong>Tarikh Mula</strong></td>
                    <td><?= $model->tarikh_mula; ?></td>
                </tr>
                <tr>
                    <td><strong>Tarikh Tamat</strong></td>
                    <td><?= $model->tarikh_tamat;?></td>
                </tr>
                
                <tr>
                    <td><strong>Status Pengajian</strong></td>
                    <td><?= $model->status_pengajian;?></td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</div>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'data-pjax' => true ]]); ?>

<div class="x_panel"> 
        <div class="form-group" id="tempoh" >
                <div class="panel-heading">
                    <h3 class="panel-title"><u>Kemaskini Maklumat Pengajian Lanjutan</u></h3>
        </div><br/>
        <div class="form-group">
                 &nbsp;&nbsp;&nbsp;<label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun:<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-10">
                    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
                 <div class="form-group">
                 &nbsp;&nbsp;&nbsp;<label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pengajian:<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-10">
                    <?= $form->field($model, 'status_pengajian')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
            </div>
        
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
       </div>
    <div class="x_panel"> 
        <div class="form-group" id="tempoh" >
                <div class="panel-heading">
                    <h3 class="panel-title"><u>Kemaskini Bon Perkhidmatan</u></h3>
        </div><br/>
                 <div class="form-group">
                 &nbsp;&nbsp;&nbsp;<label class="control-label col-md-3 col-sm-3 col-xs-12">Bon Perkhidmatan (Tahun):<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-10">
                    <?= $form->field($model, 'bon')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
            </div>
        
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
       </div>
   
    
           

            <?php ActiveForm::end(); 
            Pjax::end();?>
