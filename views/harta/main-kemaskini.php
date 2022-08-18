<?php
use yii\helpers\Html;
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>


<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 
        <div class="x_content">
             <div class="table-responsive">
                <strong>  
                    
                    Sebarang pertanyaan dan kemusykilan mengenai sistem Perisytiharan Harta sila hubungi talian berikut:<br/><br/>
                  
                      <table  class="table table-bordered jambo_table">
                        <tr>
                            <td width="1px">Nama Sistem</td>
                            <td width="1px">Perisytiharan Harta</td>
                        </tr>
                        
                     <tr>
                            <td width="1px">Garis Panduan</td> 
                            <td width="1px"> <?php ?>
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/infografik harta.png'); ?>" target="_blank" ><u>Garis Panduan.pdf</u></a>
                    <?php 
?></td>
                        </tr>  
                        
                        <tr>
                            <td width="1px">Pegawai Bertanggungjawab</td> 
                            <td width="1px">1. Puan Siti Salwa Basri    (Tel: 0109300039)<br>
                             2. Puan Hafizah Binti Hassan  (Tel: 0102386110)</td>
                        </tr>  
                    </table>
                    
                </strong>
             </div>
        </div>


        <div class="x_title">
            <h2><strong>Kemaskini Maklumat Pegawai & Harta </strong></h2> 
            <div class="clearfix"></div>
        </div>
      
                 <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Maklumat Pegawai',
                                        'text' => 'Kemaskini Maklumat Pegawai',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['harta/maklumat-pegawai']);
                    ?>
                </div>
                   
                <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Pertambahan Harta',
                                        'text' => 'Pertambahan Harta Baharu',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['harta/pengkemaskinian']);
                    ?>
                </div>
                
                 <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Lupus Harta',
                                        'text' => 'Sekiranya ingin melupuskan harta',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['harta/pelupusan']);
                    ?>
                </div>
                
                 <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Tiada Perubahan',
                                        'text' => 'Tiada perubahan pada harta sedia ada',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['harta/pengakuan-pegawai3']);
                    ?>
                </div>

            </div>


        </div>

