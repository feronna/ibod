<?php ?>
<h4 class="text-center"><strong>_____________________________________________________________ </strong></h4>
    <br>
    <h4 class="text-center"><strong>TUNTUTAN KLINIK PANEL </strong></h4>
    <h4 class="text-center"><strong>_____________________________________________________________ </strong></h4>
<div class="x_panel">                
    <p><strong>NAMA KLINIK : </strong><strong><?php echo $klinik->nama ?></strong> </p>  
    <p><strong>ID TUNTUTAN : </strong><strong><?php echo $invois2->tblvisit_batch_id ?></p>
    <p><strong>BULAN TUNTUTAN : </strong><strong><?php echo strtoupper($invois2->month) ?> <a><?php echo $invois2->year; ?></a></p>  
    <p><strong>JUMLAH TUNTUTAN : </strong><strong><?php echo Yii::$app->formatter->asCurrency($sum->total_batch_claim, 'RM'); ?></strong> </p>

    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered jambo_table">
                <thead>
                    <tr class="headings">
                        <th style="background-color:#00ff66" class="text-center" >Bil</th> 
                        <th style="background-color:#00ff66" class="text-center">Tarikh <br>Rawatan</th>
                        <th style="background-color:#00ff66" class="text-center">No.KP Kakitangan</th>
                        <th style="background-color:#00ff66" class="text-center">No.KP <br>Pesakit</th>         
                        <th style="background-color:#00ff66" class="text-center">Nama Pesakit</th>         
                        <th style="background-color:#00ff66" class="text-center">Jumlah Tuntutan (RM)</th>         
                    </tr>                                             
                </thead>
                <tr> 
                <tbody>
                    <?php
                    $bil = 1;
                    $sum = 0;
                    foreach ($invois as $i) {
                        $sum = $sum + $i->jum_tuntutan;
                        ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"  style="text-align:left"><?php echo $i->rawatan_date; ?></td>
                            <td class="text-center"  style="text-align:center"><?php echo $i->visit_icno; ?></td>
                            <td class="text-center"  style="text-align:center"><?php echo $i->pesakit_icno; ?></td>
                            <td class="text-center"  style="text-align:left"><?php echo strtoupper($i->pesakit_name); ?></td>
                            <td class="text-center"  style="text-align:center"><?php echo $i->jum_tuntutan; ?></td>
                        </tr>  
                    <?php } ?>
                    <tr>
                        <td colspan="12" class="align-right text-right"><b><?= 'Jumlah : ', Yii::$app->formatter->asCurrency($sum, 'RM'); ?></b></td>
                                               
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>







