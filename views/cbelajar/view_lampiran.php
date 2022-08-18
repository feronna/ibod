<?php

use yii\helpers\Html;
?>
<br/>
<div class="x_panel">
    <div class="x_title">
        <h2>Rekod Pengesahan Dokumen Yang Dimuat Naik</h2> 
        <p align ="right">
            <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
        </p>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings">
                        <th>Bil</th>
                        <th>Nama Dokumen</th>  
                        <th>Lampiran</th> 
                    </tr>
                </thead>
                <?php
                if ($fail) {
                    $counter = 0;
                    foreach ($fail as $fail) {
                        $counter = $counter + 1;
                        ?>

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $fail->dokumen->nama_dokumen?></td>
                            <td><?=
                                    Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                        'pdf',
                                        'id' => $fail->id,
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]);?>
                                    </td>
                            
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="10" class="text-center">Tiada Rekod</td>                     
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </div>
</div>


