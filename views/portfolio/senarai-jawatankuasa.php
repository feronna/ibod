<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;

?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: left;
}

</style>



<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-info">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-success">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-info">MAKLUMAT JD</span>'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
     <div class="x_panel">
         <div class="x_content"> 
   
<?php
  echo Html::a(Yii::t('app','CARTA ORGANISASI'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','CARTA FUNGSI'), ['/portfolio/carta-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
    echo Html::a(Yii::t('app','AKTIVITI FUNGSI'), ['/portfolio/aktiviti-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);

  echo Html::a(Yii::t('app','PROSES KERJA'), ['/portfolio/proses-kerja','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI UNDANG-UNDANG'), ['/portfolio/senarai-undang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  
 echo Html::a(Yii::t('app','SENARAI BORANG'), ['/portfolio/senarai-borang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI JAWATANKUASA'), ['/portfolio/senarai-jawatankuasa','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','PERAKUAN'), ['/portfolio/perakuan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  ?>
         </div></div>


     <div class="x_panel">

        <div class="x_title">
            <strong><h2>SENARAI JAWATANKUASA</h2></strong>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        <div class="x_content">
          <div class="table-responsive">

         
                  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                 
                         <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Jawatankuasa Yang Dianggotai<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                           <?= $form->field($carta, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
              <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan:
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php if($carta->file)
                        {
                           ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                 href="<?= Url::to(Yii::$app->FileManager->DisplayFile($carta->file), true); ?>" target="_blank" ><u>Muat Turun</u></a>
                       <?php }
                       else{?>
                           <?= $form->field($carta, 'files')->fileInput()->label(false);?> </td>

                     <?php  }
?>
             
            </div>
        </div>
              <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan',['class' => 'btn btn-success']) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>
              
              
               
              
              
        </div>
        
    </div>
        
        
            </div>
    
    
    <div class="col-md-12 col-xs-12"> 
     <div class="x_panel" >
          <div class="x_content">
                                    <table class="table table-sm table-bordered">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">SENARAI JAWATANKUASA YANG DIANGGOTAI</th>
                            <th class="column-title">DOKUMEN</th>
                            <th class="column-title">TINDAKAN</th>

                      
                       
                            
                        </tr>
                        </thead>
                        <tbody>

                 <?php if($viewAktiviti) {
                    
                   foreach ($viewAktiviti as $key=>$item){
                    
                ?>
                    <tr>
                            <td><?= $key+1?></td>
                            <td> <?= $item->catatan?></td>
                            <td> <?= Html::a(''  . $item->file, Url::to(Yii::$app->FileManager->DisplayFile($item->file), true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]) ?>  </td>
                           
                                         <td width="50px" class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-senarai-jawatankuasa', 'id' => $item->id, 'myjd_id' => $item->myjd_id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-senarai-jawatankuasa', 'id' => $item->id, 'myjd_id' => $item->myjd_id], [
                                  'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td> 
                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    </table>
                     </div>
     </div></div>
    
    
    
</div>
</div>

        


   
