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
            <h2><strong>Permohonan Baharu </strong></h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            
            
            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $maklumat = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Maklumat Pegawai',
                                        'text' => 'Keterangan Mengenai Pegawai',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($maklumat, ['harta/maklumat-pegawai']);
                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $model = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => 'Pendapatan Bulanan',
                                        'text' => 'Jumlah Pendapatan dan Tanggungan Bulanan',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($model, ['harta/jumlah-pendapatan']);
                   
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $jadual_temuduga = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Tanggungan',
                                        'text' => 'Tanggungan / Ansuran Bulanan Atas Hutang / Pinjaman',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($jadual_temuduga, ['harta/jumlah-pinjaman']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Pertambahan',
                                        'text' => 'Pertambahan Harta Baharu',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($terima_tawaran, ['harta/pertambahan']);
                    ?>
                </div>
                  <div class="col-xs-12 col-md-3">
                    <?php
                    $terima_tawarans = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'book',
                                        'header' => 'Pengakuan Pegawai',
                                        'text' => 'Pengakuan Pegawai Sebelum Menghantar Borang Isytihar Harta',
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($terima_tawarans, ['harta/pengakuan-pegawai4']);
                    ?>
                </div>
            </div>


        </div>
    </div>
        </div>
