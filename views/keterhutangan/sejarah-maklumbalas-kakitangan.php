<?php
use yii\helpers\Url;
use yii\helpers\Html;

$statusLabel = [
        1 => '<span class="label label-success">Telah Dihantar</span>',
        null => '<span class="label label-warning">Belum Dihantar</span>',
];
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/keterhutangan/_menu');?>
</div>

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
                            <th class="column-title">Sebab Keterhutangan</th>
                            <th class="column-title">Tarikh Dihantar</th>
                            <th class="column-title">Status</th>
                          
                        </tr>
                        </thead>
                        <tbody>

                        <?php  foreach ($sejarah as $key => $item) ?>
                            <tr> 
                                <td><?= $key+1 ?></td>
                                <td><?= $item->reason?></td>
                                <td><?= $item->tarikh_hantar?></td>
                                <td><?= $statusLabel[$item->status_maklumbalas]?></td>
                         </tr>
                   
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

