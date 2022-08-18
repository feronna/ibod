<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\View;

error_reporting(0);

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Peribadi';
?>
<?php echo $this->render('/ikad/_menu'); ?>

<?php
$model->d_nama = $name;
$model->language_id = $id;
$model->title_bi = $title;
$model->d_jbtn_bi = $dept;
$model->title_bm = $title;
$model->d_jbtn_bm = $dept;
?>
<div class="x_panel" style="background-color:#b4c4d4;color:#37393b;">
    <div class="x_title">
        <h2>Permohonan iKad</h2>

        <div class="clearfix"></div>
    </div>
    <p style="color: green">*Permohonan Hanya dibenarkan sekali dalam setahun</i></p>
    <p style="color: green">*Urusetia berhak mengubah permohonan sekiranya perlu </i></p>
    <p style="color: green">*Berdasarkan Pekeliling Pendaftar Bil.2/2016 Peraturan Kemudahan Kad Nama (Business Card) Kakitangan Universiti Malaysia Sabah (Pindaan 2016) </i></p>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


    <div class="x_content">
        <div class="form-group ">
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-12">Language<span class="required">*</span>
                </label>
                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($model, 'language_id')->label(false)->widget(Select2::class, [
                        'data' => ['0' => 'Both (English & Malay)', '1' => 'English', '2' => 'Malay'],
                        'options' => [
                            'required' => true, 'placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'status($(this).val())',
                            'disabled' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,

                        ],
                    ]); ?>
                </div>

            </div>
        </div>
        <div class="form-group">

            <label class="control-label col-md-2 col-sm-2 col-xs-12">Title<span class="required">*</span>
            </label>
        
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">English<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'title_bi')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>

                </div>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">Malay<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                </div>
        </div>
        <div class="form-group">

            <label class="control-label col-md-2 col-sm-2 col-xs-12">Applicant Name<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->field($model, 'd_nama')->label(false)->textInput(['id' => 'inputID', 'class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

            </div>
        </div>

        <div class="form-group ">
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Education Background<span class="required">*</span>
                </label>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">English<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_edu_bi_1')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                    <?php echo $form->field($model, 'd_edu_bi_2')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>

                </div>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">Malay<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_edu_bm_1')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                    <?php echo $form->field($model, 'd_edu_bm_2')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                </div>
            </div>

            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Position<span class="required">*</span>
                </label>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">English<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_jawatan_bi')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>

                </div>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">Malay<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_jawatan_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">JFPIU<span class="required">*</span>
                </label>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">English<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_jbtn_bi')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>

                </div>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">Malay<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_jbtn_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">JFPIU Address<span class="required">*</span>
                </label>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">English<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'dept_address_bi_1')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                    <?php echo $form->field($model, 'dept_address_bi_2')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>

                </div>
                <div class=" col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">Malay<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'dept_address_bm_1')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                    <?php echo $form->field($model, 'dept_address_bm_2')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-3 col-xs-12', 'disabled' => false,]); ?>
                </div>
            </div>

            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Tel. (Office)<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'd_office_telno')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Ext. (Office)<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'd_office_extno')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Mobile No.<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'd_hpno')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Fax No.<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'd_faxno')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                </div>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Email<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'd_email')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Save & Preview', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>


    <?php
    $script = <<< JS
        
        var input = document.getElementById('inputID');

input.onkeyup = function(){
    this.value = this.value.toUpperCase();
}
JS;
    $this->registerJs($script, View::POS_END);
    ?>