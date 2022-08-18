<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?> 

 
<div class="x_panel">  
    <div class="x_content">
        <div class="x_title">
            <h2>Rekod Permohonan</h2>  
            <div class="clearfix"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>   
                    <th style="width:2%;">Bil</th>  
                    <th style="width:20%;">Tarikh Bertugas</th> 
                    <th>Tugas</th>
                    <th style="width:10%;">Status Permohonan</th>
                    <th style="width:20%;">Surat Kebenaran</th>  
                </tr>
                <?php
                if ($permohonan) {
                    $counter = 0;
                    foreach ($permohonan as $model) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>
                            <td> <?= $model->biodata->getTarikh($model->StartDate); ?> </td>
                            <td> <?= $model->tugas; ?> </td> 
                            <td> <?php
                                if ($model->status_semasa == 1) {
                                    if ($model->isChief()) {
                                        echo '<span class="label label-primary">Menunggu Perakuan VICE CHANCELLOR</span>';
                                    } else {
                                        echo '<span class="label label-primary">Menunggu Perakuan KJ</span>';
                                    }
                                } else if ($model->status_semasa == 2) {
                                    echo '<span class="label label-warning">Menunggu Perakuan BSM</span>';
                                } else if ($model->status_semasa == 3) {
                                    echo '<span class="label label-success">Lulus</span>';
                                } else if ($model->status_semasa == 4) {
                                    echo '<span class="label label-danger">Ditolak</span>';
                                } else if ($model->status_semasa == 5) {
                                    echo '<span class="label label-danger">Dibatalkan</span>';
                                }
                                ?> 
                            </td> 
                            <td> <?php
                                if ($model->biodata->department->chief == $model->ICNO) {
                                    $title = 'Ulasan PELULUS: ';
                                } else {
                                    $title = 'Ulasan KJ: ';
                                }

                                if (!in_array($model->auto, [1, 2, 3])) { //auto
                                    $ulasan = $title . ucwords(strtolower($model->approved_kj_ulasan)) . '<br/>Disahkan pada: ' . $model->approved_kj_at . '<br/><br/>Ulasan BSM: ' . ucwords(strtolower($model->approved_bsm_ulasan)) . '<br/>Disahkan pada: ' . $model->approved_bsm_at;
                                } else {
                                    $ulasan = '';
                                }
                                if ($model->status_semasa == 1 || $model->status_semasa == 2) {
                                    echo '';
                                } elseif ($model->status_semasa == 3) {
                                    echo Html::a('<i class="fa fa-download" aria-hidden="true"></i> SURAT', [
                                        'surat-w',
                                        'title' => 'Baru',
                                        'id' => $model->id
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]) . '<br/>' . $ulasan;
                                } elseif ($model->status_semasa == 4) {
                                    echo $ulasan;
                                } elseif ($model->status_semasa == 5) {
                                    echo $model->auto_desc;
                                }
                                ?> 
                            </td>  
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5">Tiada Maklumat</td>
                    </tr>
                    <?php
                }
                ?> 
            </table>
        </div> 
    </div>

</div> 
 
