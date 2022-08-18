<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


error_reporting(0);
?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>TAMBAH JENIS ELAUN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"  style="display: <?php echo $edit;?>">
    <div class="x_panel">

        
    <div class="x_content">
        
       
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered" >
                            <thead>
                                 
                    <tr> 
                        <th style="width:10%" align="right">NAMA TAJAAN</th>
                        <td style="width:20%"><?=
                        strtoupper($b->nama_tajaan) ?></td>
                       
                    </tr>  
                     <tr > 
                        <th style="width:10%" align="right">JENIS KADAR: <i class="fa fa-info-circle fa-lg"  data-toggle="tooltip" title="Kadar A: Kuala Lumpur, Pulau Pinang, Seberang Perai, Johor Bahru, Shah Alam,
                        Sepang, Klang, Kajang, Petaling Jaya, Ampang, Sabah dan Sarawak. Kadar B:  Tempat–tempat lain"></i></th>
                         <td style="width:30%">                   
                        <?= $form->field($model, 'kadar')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(\app\models\cbelajar\RefKadar::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'kadar'),
                        
                         'options' =>['placeholder' => 'Pilih', 
                            'onchange' => 'javascript:if ($(this).val() == "KADAR A"){
                        $("#a").show();$("#b").show();
                        }
                        else if($(this).val() == "KADAR B"){
                        $("#b").show();$("#a").hide();}
                        
                        else{$("#a").hide();$("#b").hide()
                        }'
                        ],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(false); ?></td>
                       
                    </tr>
                                
                    <tr  id="a" style="display: none"> 
                        <th style="width:10%" align="right">JENIS ELAUN</th>
                        <td style="width:20%">      <?= $form->field($model, 'esh')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(app\models\cbelajar\RefElaun::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'elaun'),
                        
                            'options' => [
                            'placeholder' => 'Pilih Jenis Elaun'],
                            
                            'pluginOptions' => [
                            'allowClear' => true,
                             'multiple' => true
                        ],
                    ])->label(false); ?></td>
                       
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








