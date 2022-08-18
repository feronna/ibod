<?php

use yii\helpers\Html;
?>

<div class="col-md-12">
 <?php echo $this->render('/pengesahan/_menu');?>  
</div>
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tetapan Pembukaan Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align: center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center" rowspan="2">Bil</th>
                        <th class="column-title text-center" colspan="2">Tarikh Lantikan</th>
                        <th class="column-title text-center" colspan="2">Tarikh Boleh Memohon</th>
                        <th class="column-title text-center" rowspan="2">Tindakan</th>
                    </tr>
                    <tr class="headings">
                        <th class="column-title text-center">Dari</th>
                        <th class="column-title text-center">Hingga</th>
                        <th class="column-title text-center">Dari</th>
                        <th class="column-title text-center">Hingga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($model){
                    foreach ($model as $models) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td>
                                <?= $models->getTarikh($models->start_lantikan) ?>
                            </td>
                            <td>
                                <?= $models->getTarikh($models->end_lantikan)?>
                            </td>
                            <td>
                                <?= $models->getTarikh($models->start_bolehmohon) ?> 
                            </td>
                            <td>
                                <?= $models->getTarikh($models->end_bolehmohon)?>  
                            </td>
                            <td>
                                <?= Html::a('<i class="fa fa-edit"></i>', ["editbukapermohonan", 'id' => $models->id]);?>  
                            </td>
                           
                    <?php }} ?>
                </tbody>
            </table>
             
        </div>
    </div>
</div>


