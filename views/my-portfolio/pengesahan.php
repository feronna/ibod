<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\checkbox\CheckboxX;
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/my-portfolio/_menu');?>
</div>
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app','Maklumat Umum'), ['/my-portfolio/view-maklumat-umum','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Tujuan Pewujudan Jawatan'), ['/my-portfolio/tujuan-jawatan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Akauntabiliti'), ['/my-portfolio/lihat-akauntabiliti','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Dimensi'), ['/my-portfolio/lihat-dimensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kelayakan Akademik'), ['/my-portfolio/lihat-kelayakan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Kompetensi'), ['/my-portfolio/lihat-kompetensi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','Pengalaman'), ['/my-portfolio/lihat-pengalaman','id' => $deskripsi->id], ['class' => 'btn btn-success']);

 if($display){
      echo '';
  }else{
  echo Html::a(Yii::t('app','Pengesahan'), ['/my-portfolio/pengesahan','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app','Jana JD'), ['/my-portfolio/index','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  }

?>
         </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-xs-12"> 
 <div class="x_panel"> 
        <div class="x_title">
            <h2>PENGESAHAN</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Pegawai Peraku</th>
                        <td>
                       <?php if($model->kp != null){
                          echo  $model->ketuaPerkhidmatan->CONm;
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                     
                       <td>
                       <?php if($model->kp != null){
                        echo  strtoupper($model->ketuaPerkhidmatan->jawatan->nama); echo "\n"; echo 'GRED'; echo "\n"; echo '('; echo strtoupper($model->ketuaPerkhidmatan->jawatan->gred); echo ')';
                        }else{
                            echo 'Terus Kepada Pegawai Pelulus';
                        }
                     ?></td>
                     </tr> 
                    
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Pegawai Pelulus</th>
                        <td><?= strtoupper($model->ketuaJabatan->CONm) ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?= strtoupper($model->ketuaJabatan->jawatan->nama)?> GRED (<?= strtoupper($model->ketuaJabatan->jawatan->gred)?>)</td> 
                    </tr> 
                   
                     
                      <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Status Hantar</th>
                        <td><?php if($model->status_hantar != null){
                            echo '<span class="label label-success">SELESAI DIHANTAR</span>'; 
                        }
                            else{
                            echo '<span class="label label-danger">BELUM DIHANTAR</span>'; 
                          }
                        
?></td> 
                    </tr>
                       <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Hantar</th>
                        <td><?php if($model->status_hantar != null){
                            echo $model->tarikh_hantar; 
                        }
                            else{
                            echo '<span class="label label-danger">BELUM DIHANTAR</span>'; 
                          }
                        
?></td> 
                    </tr>
                    
                </table>
             
               <div class="x_panel" style="display: <?php echo $displaymohon;?>">
               <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
               <?php
               
               echo $form->field($model, 'status_hantar')->widget(CheckboxX::classname(), [
       
                       'autoLabel' => true,
                       'labelSettings' => [
                      'label' => '  <h style="color: green">
                * Pemohon hendaklah memastikan segala butiran didalam borang adalah betul sebelum dihantar
                </h>',
                        'position' => CheckboxX::LABEL_RIGHT
                          ]
                       ])->label(false);
               
               
               ?>
                 
                    <div class="ln_solid"></div>

            <div class="form-group">
                <div>
                 
                    <?= Html::submitButton('Hantar Deskripsi',['class' => 'btn btn-success', 'data'=>['confirm'=>'Sila pastikan semua maklumat adalah tepat. Borang yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
              
                </div>
            </div>
              </div>
                

               <?php ActiveForm::end(); ?>


            </div>
            </div> 

        </div>
    </div>
</div>




            
       
