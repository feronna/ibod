<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;

?>

    <?php echo $this->render('/harta/_menu');?> 

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Akses</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
          <div class="table-responsive">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($adminbaru, 'akses_icno')->label(false)->  widget(Select2::classname(), [
                    'data' => $allbiodata,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
              
             <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Akses<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($adminbaru, 'jenis_akses')->label(false)->  widget(Select2::classname(), [
                    'data' => ([2 => 'Penyelia Sistem', 3 => 'Admin']),
                    'options' => ['placeholder' => 'Pilih Jenis Akses', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
             
                   <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($adminbaru, 'akses_dept')->label(false)->  widget(Select2::classname(), [
                     'data' => $department,
                    'options' => ['placeholder' => 'Pilih Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
              
              
                    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kampus<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($adminbaru, 'akses_campus')->label(false)->  widget(Select2::classname(), [
                   'data' => $campus,
                    'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>
</div>

