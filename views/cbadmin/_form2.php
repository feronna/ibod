<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>



<h5> <strong><center>PENGIRAAN BON PERKHIDMATAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH LAPORDIRI:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    
                        if($lapor->dt_lapordiri)
                    {
                    echo strtoupper($lapor->dtlapor);
                    }
                    else
                    {
                        echo "Tiada Maklumat";
                    }
?>                </div>
            </div>
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH MULA BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_mkhidmat',
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_tkhidmat',
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
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
       <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH BON:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'j_bon')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        
        
        
        

    </div>
    </div>
</div>
</div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <h5> <strong><center>REKOD CUTI TANPA GAJI / PINJAMAN</center></strong> </h5>
    <center><i>**Tempoh ini tidak termasuk dalam kiraan jumlah bon**</i></center>
    <div class="x_panel">

        
    <div class="x_content">
  
        <div class="form-group">
                 
            
            <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                      
                            <th colspan="7"><center>CUTI TANPA GAJI/PINJAMAN</center><span class="required"></span>
                               </th>
                         <?php if($data){
                             foreach ($data as $test) { ?>       
                    <tr> 
                        <th>TARIKH MULA CUTI TANPA GAJI (CTG):</th>
                        <td> <?= $test->start_date ;?></td>
                        <th>TARIKH TAMAT CUTI TANPA GAJI (CTG):</th>
                            <td> <?= $test->end_date ;?>
                             <th align="center">TEMPOH:</th>
                             <td> <center><?= $test->tempoh ;?> HARI</center></td>
                       
                    </tr>
                    <?php
                            }}else{?>  <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                                    </tr>
                            <?php }?>
            </thead>
                                </table>
            
                            </div>
                    
            </div>
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>

    </div>
    </div>
</div>
</div>
