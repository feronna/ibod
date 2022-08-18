<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');
use yii\helpers\Html;
use yii\helpers\Url;    
use yii\widgets\ActiveForm;


error_reporting(0); 

$this->registerJs($js);
$title = $this->title = 'Pembiayaan / Pinjaman';

?>
<?php echo $this->render('/cutibelajar/separuhmasa/_menusm', ['title' => $title, 'id'=> $iklan->id]) ?>



<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

   
       

       
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
      <p align ="right">
               
                <?php echo Html::a('Kembali',['tambah-biasiswa-sm', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
            </p>
<table class="table table-sm table-bordered" >
<thead>
        
        <th scope="col" colspan="6" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PEMBIAYAAN / PINJAMAN</center></th>

                       <!--  <tr>
                            
                            <th valign="top" width ="40%"><center>Nama Tajaan</center></th>
                            <th  width ="40%"><center>Bentuk Bantuan</center></th>
                            <th valign="top" width ="40%"><center>Amaun</center></th>
                            
                        </tr> --> 
        <tr>
                <td valign="top" width ="30%">Nama Agensi/Tajaan:<span class="required" style="color:red;">*</span></td>
                <td colspan="4"> Saya memilih untuk melanjutkan pengajian tanpa sebarang penajaan.<?= $form->field($model, 'nama_tajaan')->textInput(['readonly' => true, 'value' => 'PERSENDIRIAN - TANPA TAJAAN'])->label(false) ?>
                    </td> 
                
     
                        
        </tr> 

          
                    </thead>
                  
                </table> 
          &nbsp;&nbsp;&nbsp;&nbsp;
             
  <div class="form-group">
      <p align ="right">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        
      </p>
        </div>

    </div>
</div>

        <?php ActiveForm::end(); ?>
  
  



