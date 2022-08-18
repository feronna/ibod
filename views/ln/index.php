<?php
use yii\helpers\Html; 
use yii\helpers\ArrayHelper; 
error_reporting(0);

?>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>  

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
        <div class="x_content">  
            <strong>
                Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
                <table>
                    <tr>
                        <td>
                            Pn Stella @ Nurul Martini Gontol<br/>
                            Timbalan Pendaftar <br/>
                            Tel: 088320000 (samb. 1410)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            Pn Hasba Mohd Basri<br/>
                            Penolong Pendaftar <br/>
                            Tel: 088320000 (samb. 2199)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        <td>
                            Pn Nur Afika Binti Taraji Fauzi<br/>
                            Pembantu Tadbir (P/O) <br/>
                            Tel: 088320000 (samb. 1157)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                        </td>
                    </tr>
                </table>
            </strong>  
        </div>
        </div>
           
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Bertugas Rasmi Ke Luar Negara </strong></h2>
            <div class="clearfix"></div>
        </div>
    <div class="well well-lg">  
    <div class="row">
                
         <div class="col-xs-12 col-md-4">
            <?php
            $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'plane',
                                'header' => 'LN-1',
                                'text' => 'Permohonan Bertugas Rasmi Ke Luar Negara (LN-1)',
                                'number' => '1',
                            ]
            ); 
            echo Html::a($dokumen, ['mohon']);
            ?>
        </div>
        
        <div class="col-xs-12 col-md-4">
            <?php
            $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'list',
                                'header' => 'Lampiran A',
                                'text' => 'Lampiran A',
                                'number' => '2',
                            ]
            );
            echo Html::a($semakan, ['lampiran-a']);
            ?>
        </div>
        
                <div class="col-xs-12 col-md-4">
            <?php
            $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'list',
                                'header' => 'LN-2',
                                'text' => 'Laporan Bertugas Rasmi Di Luar Negara (LN-2)',
                                'number' => '3',
                            ]
            );
            echo Html::a($semakan, ['senarai-mohon2']);
            ?>
        </div>
      
    </div> 
    </div>
        
    <div class="row">
    <div class="col-md-12 col-xs-12"> 
           <div class="x_panel">
           <?php echo $this->render('/ln/info');?>
    </div>
    </div>
    </div>
        
    </div>
    </div>
</div>