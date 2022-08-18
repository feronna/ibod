<?php

use yii\helpers\Html;
?>

<div class="x_panel">
    <div class="x_title">
        <h2>Rekod Pengajian Tinggi</h2> 
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
                        <th>Institut</th>  
                        <th>Tahap Pendidikan</th>
                        <th>Major</th>
                        <th>Nama Sijil (Malay)</th>
                        <th>Tarikh Dianugerahkan</th>
                        <th>CGPA</th>
                        <th>Status Pengiktirafan</th>
                        <th>Bukti Pengiktirafan</th> 
                    </tr>
                </thead>
                <?php
                if ($eduhighest) {
                    $counter = 0;
                    foreach ($eduhighest as $eduhighest) {
                        $counter = $counter + 1;
                        ?>

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td>
                                <?php
                                if ($eduhighest->InstCd == 999) {
                                    echo $eduhighest->InstNm;
                                } else {
                                    echo $eduhighest->institut->InstNm;
                                }
                                ?>
                            <td><?= $eduhighest->tahapPendidikan ?></td>
                            <td><?= $eduhighest->namamajor ?></td>
                            <td><?= $eduhighest->EduCertTitle; ?></td>
                            <td><?= $biodata->getTarikh($eduhighest->ConfermentDt) ?></td>
                            <td><?= $eduhighest->OverallGrade ?></td>
                            <td><?= $eduhighest->AcrtdEduAch ? 'Diiktiraf' : 'Tiada' ?></td>
                            <td class="text-center"> 
                                <?php if ($eduhighest->FileSisraf) { ?>

                                    <?=
                                    Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                        'pdf',
                                        'id' => $eduhighest->id, 'title' => 'Pengajian Tinggi',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]);
                                    ?>
                                    <?php
                                }
                                ?>
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


<div class="x_panel">
    <div class="x_title">
        <h2>Rekod Bahasa</h2>  
        <div class="clearfix"></div>
    </div>

    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings">
                        <th>Bil</th>
                        <th>Nama Bahasa</th>
                        <th>Kemahiran Lisan</th>
                        <th>Kemahiran Menulis</th>
                        <th>Status Pengiktirafan</th>
                        <th>Bukti Pengiktirafan</th>   
                    </tr>
                </thead>
                <?php
                if ($bahasa) {
                    $counter = 0;
                    foreach ($bahasa as $bahasa) {
                        $counter = $counter + 1;
                        ?>

                        <tr>
                            <td><?= $counter; ?></td>
                            <td><?= $bahasa->namaBahasa->Lang; ?></td>
                            <td><?= $bahasa->tahapKemahiranBahasaOral->LangProficiency; ?></td>  
                            <td><?= $bahasa->tahapKemahiranBahasaWritten->LangProficiency; ?></td> 
                            <td><?= $bahasa->certStatus; ?></td>
                            <td class="text-center"> 
                                <?php if ($bahasa->FileBahasa) { ?>

                                    <?=
                                    Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                        'pdf',
                                        'id' => $bahasa->id, 'title' => 'Bahasa',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]);
                                    ?>
                                    <?php
                                }
                                ?>
                            </td> 
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2>Rekod Kelayakan/Professional</h2>  
        <div class="clearfix"></div>
    </div>

    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings">
                        <th>Bil</th>
                        <th>Nama Sijil</th>
                        <th>Nama Badan/Organisasi</th>
                        <th>Tarikh Sijil</th> 
                        <th>Bukti Pengiktirafan</th>   
                    </tr>
                </thead>
                <?php
                if ($kelayakan) {
                    $counter = 0;
                    foreach ($kelayakan as $kelayakan) {
                        $counter = $counter + 1;
                        ?>

                        <tr>
                            <td><?= $counter; ?></td>
                            <td><?= $kelayakan->sijil_nama; ?></td>
                            <td><?= $kelayakan->sijil_bdnOrganisasi; ?></td>  
                            <td><?= $biodata->getTarikh($kelayakan->sijil_tarikh); ?></td>  
                            <td class="text-center"> 
                                <?php if ($kelayakan->FileProf) { ?>

                                    <?=
                                    Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                        'pdf',
                                        'id' => $kelayakan->id, 'title' => 'Kelayakan Profesional',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]);
                                    ?>
                                    <?php
                                }
                                ?>
                            </td> 
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2>Rekod Kecacatan</h2>  
        <div class="clearfix"></div>
    </div>

    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings">
                        <th>Bil</th>
                        <th>No. Fail Kebajikan</th>
                        <th>No. Laporan Doktor</th>
                        <th>Jenis Kecacatan</th>
                        <th>Punca Kecacatan</th>
                        <th>Tarikh Kecacatan</th> 
                        <th>Tarikh Sembuh</th>
                        <th>Kad Kebajikan</th>  
                    </tr>
                </thead>
                <?php
                if ($kecacatan) {
                    $counter = 0;
                    foreach ($kecacatan as $kecacatan) {
                        $counter = $counter + 1;
                        ?>

                        <tr>
                            <td><?= $counter; ?></td>
                            <td><?= $kecacatan->SocialWelfareNo; ?></td>
                            <td><?= $kecacatan->DrRptNo; ?></td>
                            <td><?= $kecacatan->jenisKecacatan->DisabilityType; ?></td>
                            <td><?= $kecacatan->puncaKecacatan->DisabilityCause; ?></td>
                            <td><?= $biodata->getTarikh($kecacatan->DisabilityDt); ?></td> 

                            <?php if ($kecacatan->HealDt) { ?>
                                <td><?= $biodata->getTarikh($kecacatan->HealDt); ?></td>
                            <?php } else { ?>
                                <td><?= $kecacatan->HealDt ? $kecacatan->HealDt : 'Tidak Berkaitan'; ?></td>
                            <?php } ?>

                            <td class="text-center"> 
                                <?php if ($kecacatan->FileOku) { ?>

                                    <?=
                                    Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                        'pdf',
                                        'id' => $kecacatan->id, 'title' => 'Kecacatan',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]);
                                    ?>
                                    <?php
                                }
                                ?>
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


<div class="x_panel">
            <div class="x_title">
                <h2>Rekod Lesen</h2>  
                <div class="clearfix"></div>
            </div>

            <div class="x_content">   
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th>Bil</th>
                                <th>No. Lesen</th>
                                <th>Jenis Lesen</th> 
                                <th>Kelas Lesen</th>
                                <th>Tarikh Dikeluarkan</th> 
                                <th>Tarikh Luput</th>
                                <th>Bukti Lesen</th>  
                            </tr>
                        </thead>
                        <?php
                        if ($lesen) {
                            $counter = 0;
                            foreach ($lesen as $lesen) {
                                $counter = $counter + 1;
                                ?>

                                <tr>
                                    <td><?= $counter; ?></td>
                                    <td><?= $lesen->LicNo; ?></td>
                                    <td><?= $lesen->jenisLesen->LicType; ?></td>
                                    <td><?= $lesen->kelasLesen->LicClass; ?></td>
                                    <td><?= $lesen->FirstLicIssuedDt; ?></td>
                                    <td><?= $lesen->LicExpiryDt; ?></td> 
                                    <td class="text-center"> 
                                        <?php if ($lesen->FileLesen) { ?>

                                            <?=
                                            Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                                'pdf',
                                                'id' => $lesen->licId, 'title' => 'Lesen',
                                                    ], [
                                                'class' => 'btn btn-default',
                                                'target' => '_blank',
                                            ]);
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </td> 
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