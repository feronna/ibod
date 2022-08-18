<?php
 use yii\helpers\Html;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">  
 
        <div class="x_panel"> 
            <div class="x_title">
                <h2>Rekod Permohonan Semasa</h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th>Bil</th>
                                <th>Nama Pegawai</th>
                                <th>Jawatan</th>
                                <th>JFPIU</th>
                                <th>Kampus</th> 
                                <th>Tarikh</th>
                                <th>Masa</th>  
                                <th>Chief</th>
                            </tr>
                        </thead>
                        <?php
                        if ($permohonan) {
                            $counter = 0;
                            foreach ($permohonan as $permohonan) {
                                $counter = $counter + 1;

                               if (date('Y-m-d',strtotime($permohonan->datetime)) == date("Y-m-d")) {
                                    $bg = "#FFC0CB";
                                } else {
                                    $bg = "#FFFFFF";
                                }
                                ?>

                                <tr>
                                    <td bgcolor=<?= $bg; ?>><?= $counter; ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= ucwords(strtolower($permohonan->biodata->CONm)); ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->jawatan->nama; ?> (<?= $permohonan->biodata->jawatan->gred; ?>)</td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->department->fullname; ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->kampus->campus_name; ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->getTarikh($permohonan->datetime); ?></td> 
                                    <td bgcolor=<?= $bg; ?>><?= date('h:i A',strtotime($permohonan->datetime)); ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodataKeselamatan->CONm; ?></td>  
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="8" class="text-center">Tiada Rekod</td>                     
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
        </div>  

     
</div>  

