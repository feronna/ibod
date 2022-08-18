<?php
use yii\helpers\Url;
use yii\helpers\Html;

$statusLabel = [
        1 => '<span class="label label-success">Telah Dihantar</span>',
        null => '<span class="label label-warning">Belum Dihantar</span>',
];
?>


<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2><strong>Sejarah Maklumbalas Kakitangan</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-sm jambo_table">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">Bil</th>
                            <th class="column-title">Representasi Bertulis</th>
                            <th class="column-title">Tarikh Dihantar</th>
                            <th class="column-title">Status</th>
                          
                        </tr>
                        </thead>
                        </thead>
                <?php if($sejarah) {
                    
                   foreach ($sejarah as $sejarahs) {
                    
                ?>
                  
                <tr>
                    <td><?= $bil+1 ?></td>
                    <td><?= $sejarahs->reason ?></td>
                    <td><?= $sejarahs->tarikh_hantar_maklumbalas?></td>
                    <td><?= $statusLabel[$sejarahs->status_maklumbalas]?></td>
                  
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>

                    </table>

                </div>
            </div>
        </div>
    </div>

