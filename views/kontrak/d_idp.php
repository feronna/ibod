<div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Program Pembangunan Individu</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">Program</th>
                    <th class="text-center">Tarikh</th>
                    <th class="text-center">Jenis Kompetensi</th>
                    <th class="text-center">Peringkat</th>
                    <th class="text-center">Kategori</th>
                </tr>
               </thead>
                <?php
                if ($model->latihan) { $bil1=1;?>
                    <?php foreach ($model->latihan as $l) { 
                        if ($l->senarailatihan->vcsl_tkh_mula >= $model->kakitangan->startDateLantik &&
                                $l->senarailatihan->vcsl_tkh_mula <= $model->kakitangan->endDateLantik) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_latihan; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->tarikhmulalatihan; ?></td>
                            <td class="text-center"><?php echo $l->jeniskompetensi->vcks_nama_kompetensi; ?></td>
                            <td class="text-center"><?php echo $l->senarailatihan->vcsl_nama_peringkat; ?></td>
                            <td class="text-center"><?php echo $l->kategori->rck_deskripsi_aktiviti; ?></td>
                        </tr>
                    <?php } }?>
                <?php }
                if ($model->latihanbaru) {?>
                    <?php foreach ($model->latihanbaru as $l) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $l->sasaran3->tajukLatihan; ?></td>
                            <td class="text-center"><?php echo $l->tarikhMula; ?></td>
                            <td class="text-center"><?php echo $l->sasaran3->kompetensiii->kategori_nama; ?></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    <?php } ?>
                <?php }
                ?>
            </table>
    </div>
        </div>
    </div>
</div>