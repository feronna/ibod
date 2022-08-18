<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\pengesahan\Pengesahan;
use yii\helpers\ArrayHelper;

error_reporting(0);
$bil=1;

?>

 <?php echo $this->render('/pengesahan/_menu');?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Permohonan Pengajian Lanjutan (Akademik)</h2>
            <div class="clearfix"></div>
        </div>
    <div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
        
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan & Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>
            <div class="form-group">         
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU<span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
           
            
        </div>
        </div>
    </div>
</div>
       
<div class="col-md-12 col-sm-12 col-xs-12"> 
  
            
<div class="col-md-12" > 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_jfpiu;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
           
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhkj;?>" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
</div>
        
<div class="col-md-12" > 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Kelulusan BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_bsm;?>" disabled="disabled">
                </div>
            </div>
           
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhlulus;?>" disabled="disabled">
                </div>
            </div>
        </div>
    </div>
</div>
            <?php ActiveForm::end(); ?>
    </div>
</div>


