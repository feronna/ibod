<?php

use yii\helpers\Html;
?> 
<?= $this->render('menu') ?> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">  
        <div class="x_content">
            <div class="x_title">
                <h2>Surat Bertugas Ppv</h2>  
                <div class="clearfix"></div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>   
                        <th style="width:2%;">Bil</th>  
                        <th style="width:20%;">Tarikh Bertugas</th>  
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
                                <td> <?=
                                    Html::a('<i class="fa fa-download" aria-hidden="true"></i> SURAT', [
                                        'surat-w',
                                        'id' => $model->id,
                                        'title' => 'Ppv',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]);
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
</div>