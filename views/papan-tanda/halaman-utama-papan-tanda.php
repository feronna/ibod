<?php
use yii\helpers\Html; 
use yii\helpers\ArrayHelper; 
error_reporting(0);

$link_papan_tanda_mohon = 'mohon?id='.$model->event_id;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
<!--        <div class="x_panel">
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
        </div>-->
           
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> PAPAN TANDA </strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['e-perkhidmatan/senarai-permohonan?id='.$model->event_id], ['class' => 'btn btn-primary']) ?></p>      
            <div class="clearfix"></div>
        </div>
    <div class="well well-lg">  
    <div class="row">
                
         <div class="col-xs-12 col-md-4">
            <?php
            $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'pencil',
                                'header' => 'Papan Tanda',
                                'text' => 'Permohonan Papan Tanda',
                                'number' => '1',
                            ]
            ); 
            echo Html::a($dokumen, ['mohon?id='.$model->event_id]);
            ?>
        </div>

        <div class="col-xs-12 col-md-4">
            <?php
            $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'user',
                                'header' => 'Semakan Permohonan',
                                'text' => 'Semakan Permohonan Papan Tanda',
                                'number' => '2',
                            ]
            );
            echo Html::a($semakan, ['semakan-permohonan']);
            ?>
        </div>
        
                <div class="col-xs-12 col-md-4">
            <?php
            $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'user',
                                'header' => 'Sejarah Permohonan',
                                'text' => 'Sejarah Permohonan Papan Tanda',
                                'number' => '3',
                            ]
            );
            echo Html::a($semakan, ['halaman-utama-papan-tanda?id='.$model->event_id]);
            ?>
        </div>
      
    </div> 
    </div>
        
    </div>
    </div>
</div>