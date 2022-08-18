<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//yii\helpers\VarDumper::dump($jenis_cuti,10,true);

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

?>
<?php echo $this->render('/ikad/_menu'); ?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>Pilih Bahasa</i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Bahasa</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                   title="Leave Type"></i>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
                 <?=
                        $form->field($model, 'language_id')->label(false)->widget(Select2::classname(), [
                            'data' => ['0' => 'Both (English & Malay)', '1' => 'English', '2' => 'Malay'],
                            'options' => ['placeholder' => 'Choose Business Card Language', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
            </div>

        </div> 
        <!-- <div class="form-group">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <p style="color: red">
                    * Sila pastikan anda mempunyai akaun emel UMS yang tepat yang telah dikemaskini di dalam HROnline.
                    Emel yang tepat diperlukan untuk tujuan penghantaran notifikasi kepada anda
                </p>
            </div>
        </div> -->
        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/individu/index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Next', ['class' => 'btn btn-success','data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!-- <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>Kelayakan Permohonan Cuti Penyelidikan</i></u> </strong></font><br><br>

                                <span>1. </span> Kakitangan Akademik berstatus Aktif. &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span>2. </span> Disahkan dalam Perkhidmatan &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span>3. </span> Telah Berkhidmat Sekurang-kurangnya 3 tahun &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span>4. </span> Cuti Penyelidikan Terkumpul kurang daripada 3 bulan &nbsp;&nbsp;&nbsp;&nbsp;<br>
                             
                            </div> -->
</div>

