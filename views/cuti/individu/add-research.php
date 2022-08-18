<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\cuti\Layak;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use app\models\smp_ppi\CutiPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use yii\helpers\Url;

//english title
?>
<style>
    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-file-o"></i>&nbsp;<strong>Research Details</i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Data From SMPPPI</legend>
        <div class="control-group">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project ID
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $rs_d->ProjectID ?>" disabled="true">
                </div>
            </div>
        </div>

        <div class="clearfix"></div><br></br>
        <div class="control-group">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Research Title
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $rs_d->TajukPenyelidikan ?>" disabled="true">
                
                </div>
            </div>
        </div>

        <div class="clearfix"></div><br></br>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Research Summary
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <textarea name="txt_descripcion" class="form-control col-md-7 col-xs-12" cols="40" rows="15" id="txt_descripcion" disabled="true"><?php echo htmlspecialchars($rs_d->RingkasanPenyelidikan); ?> </textarea>
            </div>

        </div>
        <div class="clearfix"></div><br></br>
        <div class="control-group">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Research Address
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $rs_d->TempatPenyelidikan ?>" disabled="true">
                </div>
            </div>
        </div>
        <div class="clearfix"></div><br></br>
        <div class="control-group">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Expected Output
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
                </label>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea name="txt_descripcion" class="form-control col-md-7 col-xs-12" cols="10" rows="15" id="txt_descripcion" disabled="true"><?php echo htmlspecialchars($rs_d->JangkanHasil); ?> </textarea>

                </div>
            </div>
        </div>
        <div class="clearfix"></div><br></br>
        <div class="control-group">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">organizer
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Pengawai Memperaku Cuti"></i>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control col-md-7 col-xs-12" value="<?php echo $rs_d->Penganjur ?>" disabled="true">
                </div>
            </div>
        </div>

    </fieldset>


    <div class="clearfix"></div><br></br>
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">Data Needed From User</legend>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Application Justification
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'summary')->textarea(['rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Penetapan KPI sepanjang Cuti

                <label class="control-label col-md-12 col-sm-12 col-xs-12">a. Faedah kepada tugas hakiki
                </label>

                <label class="control-label col-md-12 col-sm-12 col-xs-12"> b. Faedah kepada Universiti
                </label>

                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'summary')->textarea(['rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="x_title">

            

            <div class="ln_solid"></div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/edit-cp', 'id' => $cid], ['class' => 'btn btn-warning']) ?>
                    <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..','confirm'=>'Are You Sure??']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    </fieldset>