<?php

use yii\widgets\ActiveForm;
use app\models\kehadiran\RefReason;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\keselamatan\cuti;
?>
<!--<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li>Alasan & Sebab ketidakpatuhan</li>
    </ol>
</div>-->

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Cuti Rehat Dalam Negara</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pemohon :
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->pemohon->CONm ?>" disabled="">

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Memperaku :
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->peraku->CONm ?>" disabled="">

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Melulus :
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->pelulus->CONm ?>" disabled="">
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Tarikh Mula Cuti <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model2,
                        'attribute' => 'cuti_mula',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Tarikh Akhir Cuti <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model2,
                        'attribute' => 'cuti_tamat',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model2, 'cuti_catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>        
            <div class="ln_solid"></div>
<?php if($layak->bakicuti != 0){?>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Alasan/ Sebab', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
<?php }else{ ?><div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Alasan/ Sebab', ['class' => 'btn btn-success','disabled'=>'disabled']) ?>
                </div>
            </div><?php }?>
           
            <?php ActiveForm::end(); ?>

            <!--form-->

        </div>
    </div>
</div>