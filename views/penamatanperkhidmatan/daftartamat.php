<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\penamatanperkhidmatan\RefSebabpendeknotis;
use app\models\penamatanperkhidmatan\TblPermohonan;
use app\models\hronline\Tblprcobiodata;
?>

<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>

<?= $this->render('_topmenu') ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Penamatan Perkhidmatan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); 
            $model->scenario = 'bm';?>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Penamatan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'jenis_penamatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblJenispenamatan::find()->where(['diisi_oleh'=> 'bsm'])->all(), 'id', 'jenis'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'icno')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['Status'=> '1'])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Terakhir Bekerja<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= DatePicker::widget([
                'name'  => 'terakhir',
                'readonly' => true,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                ]); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Penamatan<span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'sebab')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <br>
         <script>
                    function myFunction(val) {
                        if(val === "mohon"){
                            $("#mohon").show();
                        }
                        else{
                            $("#mohon").hide();
                        }
                    }
                    </script>
        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary', 'data'=>['confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Teruskan?']]) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>



