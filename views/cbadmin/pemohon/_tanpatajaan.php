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
<div class="col-md-12 col-sm-12 col-xs-12"> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
<div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN BAHARU PENGAJIAN LANJUTAN PENTADBIRAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=> $iklan->id]) ?>



<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

   
       

       
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
         <p align="right"> <?php echo Html::a('Kembali',  ['tambah-biasiswa',  'id' => $iklan->id], ['class' => 'btn btn-primary btn-sm']); ?> </p>

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
  
  



