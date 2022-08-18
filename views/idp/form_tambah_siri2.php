<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo $this->render('/idp/_topmenu');
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">    
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-info-circle"></i> Maklumat Kursus</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PEMILIK MODUL</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">Pemilik Modul:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($modelLatihan, 'penggubalModul')->textInput()->input('readOnlyTextInput',['readOnly' => true, 'value' => $modelLatihan->penggubalModul])->label(false) ?>
                    </div>
                </div>
                  <?php ActiveForm::end(); ?> 
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
        </div>
    </div>




