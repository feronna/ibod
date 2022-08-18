<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>TAMBAH JENIS ELAUN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                 
                    <tr> 
                        <th style="width:10%" align="right">NAMA TAJAAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->nama_tajaan) ?></td>
                       
                    </tr>         
                                
                    <tr> 
                        <th style="width:10%" align="right">JENIS ELAUN</th>
                        <td style="width:20%">      <?= $form->field($model, 'esh')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(app\models\cbelajar\RefElaun::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'elaun'),
                        'options' => [
                            'placeholder' => 'Pilih Jenis Elaun'],
                    ])->label(false); ?></td>
                       
                    </tr>
                    
                                  
                    <tr> 
                        <th style="width:20%" align="right">BAYARAN OLEH (KPT/UMS):</th>
                        <td style="width:30%">                    <?= $form->field($model, 'ebk')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">AMAUN (RM/USD/EURO/ETC)</th>
                         <td style="width:30%">                    <?= $form->field($model, 'ebk')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
</td>
                       
                    </tr>
                    
                   
                    
                    
                     
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div>
                    
    


         
        
        
        


    </div>
    </div>



        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
<center> <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?></center>
            </div>    </div>
        </div>

<?php ActiveForm::end(); ?>








