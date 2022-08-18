<?php
use app\models\kontrak\TblKpi;
error_reporting(0);
?>
<style>
table, th, td {
  border-collapse: collapse;
}
td{
    text-align:center;
    border: 1px solid black;
}
</style>
<div>
<table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                                <tr class="headings">
                                    <th style="border: 1px solid black; border-bottom: none;" class="text-center">Bil / <i>No.</i></th>
                                    <th style="border: 1px solid black; border-bottom: none" class="text-center">Jenis KPI / <i>Type of KPI</i></th>
                                    <th style="border: 1px solid black;" class="text-center" colspan="3">Di Fakulti / Pusat / Institut<br>
                                        <i>At Faculty / Center / Institute</i></th>
                                </tr>
                            </thead>
                            <tr>
                                <th style="border: 1px solid black; border-top: none"></th><th style="border: 1px solid black; border-top: none"></th>
                                    <th style="border: 1px solid black;" class="text-center">Bilangan / <i>Number</i></th>
                                    <th style="border: 1px solid black;" class="text-center">Jumlah / <i>Amount</i> (RM)</th>
                                    <th style="border: 1px solid black;" class="text-center">Ketua / Ahli / <br><i>Leader / Member</i></th>
                                    <?php 
                                    
                                    $mod = TblKpi::find()->where(['kontrak_id' => $kontrak->id])->one();?>
                                </tr>
                <tbody>
                        <?php
                            if ($kriteriakpi) { $no=0;?>
                                <?php foreach ($kriteriakpi as $kpi) { $no++; 
                                $model = TblKpi::kpi_user($kontrak->id, $kpi->id);
                        $count = count($model);
                                ?>
                            <?php if($kpi->id<=3){?>
                                <tr>
                                    <td rowspan="<?= $count?>"><?= $no?></td>
                                    <td rowspan="<?= $count?>"><?= ''.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em>' ?></td>
                                    <?php $first=1; foreach($model as $m){
                                        if($first === 1){?>
                                        <td class="text-center" style="color:black"><?= $m->catatan?></td>
                                        <td class="text-center" style="color:black"><?= number_format($m->catatan_2,2)?></td>
                                        <td class="text-center" style="color:black"><?= $m->catatan_3?></td>
                                </tr>
                            <?php }
                            else{
                                        ?>
                                    <tr>
                                        <td class="text-center" style="color:black"><?= $m->catatan?></td>
                                        <td class="text-center" style="color:black"><?= number_format($m->catatan_2,2)?></td>
                                        <td class="text-center" style="color:black"><?= $m->catatan_3?></td>
                                    </tr>
                                        <?php } $first++; }?>
                                </tr>
                            <?php }
                            elseif($kpi->id==4){?>
                                    <tr>
                                        <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= $kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Bilangan / <i>Number</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Jenis / <i>Type</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Peranan / <i>Role</i></div>
                                        
                                    </td>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                    </tr>
                                    <?php } }
                                    elseif($kpi->id==5){?>
                                    <tr>
                                        <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= $kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Bilangan / <i>Number</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Peranan / <i>Role</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Tahap / <i>Level</i></div>
                                        
                                    </td>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                    </tr>
                                    <?php } }
                                    elseif($kpi->id==6){?>
                                    <tr>
                                        <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= $kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Bilangan Kursus / <i>Number of Courses</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Bilangan Jam Per Sem / <i>Number of Hours Per Sem</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Bilangan Pelajar / <i>Number of Students</i></div>
                                        
                                    </td>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                    </tr>
                                    <?php } }
                                    elseif($kpi->id==7){?>
                                    <tr>
                                        <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= $kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Bilangan Pelajar / <i>Number of Students</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Tahap / <i>Level</i></div>
                                        
                                    </td>
                                    <td style="padding:0px;" class="text-center">
                                        <div style="font-weight: bold; padding: 8px;">Peranan / <i>Role</i></div>
                                        
                                    </td>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                    </tr>
                                    <?php }  } 
                                    else{?>
                                    <tr>
                                        <td class="text-center"><?= $no; ?></td>
                                    <td style="position: relative;" class="text-center"><?= $kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    
                                        <?php foreach($model as $m){?>
                                        <td colspan="3" style="color: black;padding: 10px;white-space:pre-line;"><?= $m->catatan?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php }  
                            }}?>
                            
                </tbody>
            </table></div>