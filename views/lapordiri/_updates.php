<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\hronline\MajorMinor; 
use kartik\select2\Select2;
use app\models\hronline\Negara;
/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>KEMASKINI SEMAKAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
       
       <table class="table table-sm table-bordered">
    
                    <tr>
            <td width="40%"><strong>SEMAKAN PERMOHONAN:</strong></td>
            <td><?=
                    $form->field($model,'status_semakan')->label(false)->widget(Select2::classname(), [
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan' => 'TIDAK LAYAK DIPERTIMBANGKAN', 'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dimajukan untuk pertimbangan JK Pengajian Lanjutan Akademik"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Dokumen Tidak Lengkap"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
</td>
    </tr>

               
                    <tr> 
                        <th style="width:10%" align="right">CATATAN:</th>
            <td>                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>

                       
                    </tr>
    
    
</table>

        
            
        
        
    </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    

        
    <div class="x_content">
  
       
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>

