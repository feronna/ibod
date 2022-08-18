<?php
use yii\helpers\Html;

?>

<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 
        <div class="x_content">
             <div class="table-responsive">
                <strong>  
                    
                  <?= Yii::t('app', 'Sebarang pertanyaan dan kemusykilan mengenai sistem Tindakan Tatatertib Kakitangan sila hubungi talian berikut')?>:<br/><br/>
                  
                      <table  class="table table-bordered jambo_table">
                        <tr>
                            <td width="1px"><?= Yii::t('app','NAMA SISTEM')?></td>
                            <td width="1px"><?= Yii::t('app','TINDAKAN TATATERTIB')?></td>
                        </tr>
      
                        
                        <tr>
                            <td width="1px"><?= Yii::t('app','PEGAWAI BERTANGGUNGJAWAB') ?></td> 
                            <td width="1px">1. Puan Farrah binti Husain (Tel: 088320000 (<?= Yii::t('app','samb')?>. 1090)<br>
                             2. Puan Hafizah Binti Hassan  010-2386110</td>
                        </tr>  
                    </table>
                    
                </strong>
             </div>
        </div>
       

        <div class="x_title">
            <h3><strong><span class="label label-success" style="color: white"><?= Yii::t('app','TINDAKAN TATATERTIB KAKITANGAN')?> </span></strong></h3> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="row">
                   <div class="col-xs-12 col-md-3">
                         <?php
                 $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'edit',
                            'header' => 'Rekod Kes',
                            'text' => 'Rekod Kes',
                            'number' => '1',
                        ]
                         );
                        
                        echo Html::a($terima_tawaran, ['tatatertib-staf/admin-rekod-kes-staf']);
                      //  echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['brp/pengesahan', 'brp_id' => $senarai->brp_id]),'style'=>'background-color: transparent; 
                               //  border: none;', 'class' => 'fa fa-edit mapBtn']) ;
                         ?> 
                   </div>
                
                   <div class="col-xs-12 col-md-3">
                         <?php
                       $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'edit',
                            'header' => 'Keputusan NC',
                            'text' => 'Keputusan NC',
                            'number' => '2',
                        ]
                         );
                        
                        echo Html::a($terima_tawaran, ['tatatertib-staf/keputusan-nc']);
                      //  echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['brp/pengesahan', 'brp_id' => $senarai->brp_id]),'style'=>'background-color: transparent; 
                               //  border: none;', 'class' => 'fa fa-edit mapBtn']) ;
                         ?> 
                   </div>
                
                  <div class="col-xs-12 col-md-3">
                        <?php
                        $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'edit',
                            'header' => 'Urus Mesyuarat JTK',
                            'text' => 'Urus Mesyuarat',
                            'number' => '3',
                        ]
        );
         echo Html::a($terima_tawaran, ['tatatertib-staf/admin-urus-mesyuarat']);
        ?>
    </div>
                
     <div class="col-xs-12 col-md-3">
                         <?php
                        $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'edit',
                            'header' => 'Rekod Mesyuarat JTK',
                            'text' => 'Rekod Kes',
                            'number' => '4',
                        ]
                         );
                        
                        echo Html::a($terima_tawaran, ['tatatertib-staf/admin-post-list-keseluruhan']);
                      //  echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['brp/pengesahan', 'brp_id' => $senarai->brp_id]),'style'=>'background-color: transparent; 
                               //  border: none;', 'class' => 'fa fa-edit mapBtn']) ;
                         ?> 
                   </div>
                
   
                
    <div class="col-xs-12 col-md-3">
        <?php
         $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'pie-chart',
                            'header' => 'Rekod Keputusan JTK',
                            'text' => 'Rekod Mesyuarat',
                            'number' => '5',
                     
                        ]
        );
      
        echo Html::a($terima_tawaran, ['tatatertib-staf/admin-post-primafacie']);
        ?>
    </div>
                
         <div class="col-xs-12 col-md-3">
        <?php
          $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'pie-chart',
                            'header' => 'Urus Mesyuarat JRTK',
                            'text' => 'Jawatankuasa Rayuan',
                            'number' => '6'
                            
                        ]
        );
        echo Html::a($terima_tawaran, ['tatatertib-staf/admin-urus-mesyuarat-jrtk']);
        ?>
    </div>
             
         <div class="col-xs-12 col-md-3">
        <?php
     $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'pie-chart',
                            'header' => 'Rekod Keputusan JRTK',
                            'text' => 'Jawatankuasa Rayuan',
                            'number' => '7'
                            
                        ]
        );
        echo Html::a($terima_tawaran, ['tatatertib-staf/admin-post-list-keseluruhan-jrtk']);
        ?>
    </div>
                
                        <div class="col-xs-12 col-md-3">
        <?php
     $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                        [
                            'icon' => 'pie-chart',
                            'header' => 'Rekod Tatatertib',
                            'text' => 'Rekod kes terdahulu',
                            'number' => '8'
                            
                        ]
        );
        echo Html::a($terima_tawaran, ['tatatertib-staf/senarai-kes-terdahulu']);
        ?>
    </div> 
                
                

        <?php  ?>
                  
        


       </div>
    </div>
      
          
      
</div>
</div>



    
    
       
    




