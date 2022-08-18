<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Permohonan Tukar Syif</strong></h2>
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
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->pemohon->CONm ?>" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pelulus:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $model->pelulus->CONm?>" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Yang Dipohon :
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $date ?>" disabled="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Syif Sekarang:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" class="form-control col-md-6 col-sm-6 col-xs-12" value="<?= $self ?>" disabled="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Penganti <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model2, 'shift_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map($penganti, 'id', function($penganti) {
                                        return $penganti->staff->CONm;
                                    }),
                            'options' => ['placeholder' => 'Pilih Penganti', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>            
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sila Beri Alasan Yang Terperinci :<span class="required red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model2, 'alasan_penukaran')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Set Semula</button>
                        <?= Html::submitButton('Hantar Permohonan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

                <!--form-->

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Anggota Yang Boleh Dipohon untuk Ditukar </strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Tarikh</th>
                                <th class="text-center">Syif</th>
                                <th class="text-center">Pos Kawalan</th>
                            </tr>
                        </thead>
                        <?php foreach ($penganti as $models) { ?>
                            <tr>

                                <td class="text-center"  style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->staff->CONm ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->wp->details ?></td>
                                <td class="text-center"  style="text-align:center"><?= $models->pos->pos_kawalan ?></td>

                            </tr>
                        <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
