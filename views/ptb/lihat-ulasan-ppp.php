<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
 $options = [ 2 => 'Tidak Disokong',
              1 => 'Disokong',
              null => 'Tiada Tindakan'
        ];


?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-info">&nbsp&nbsp</i>Lihat Ulasan PPP</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Pegawai Penyelia Pertama
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <?= Html::textInput('', $models->namaPp->CONm, ['class' => 'form-control inline', 'disabled' => true]) ?>
                        </div>
                    </div>
                          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pegawai Penyelia Pertama
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $options[$models->status_ppp]?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan PPP
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">
                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $models->ulasan_ppp?>" disabled="">
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    
                <?php ActiveForm::end(); ?>
                <!--form-->
            </div>
            </div>
        </div>
    </div>
</div>

