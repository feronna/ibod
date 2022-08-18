<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

use yii\helpers\Html;
?>  

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2>Resume</h2> 
                <p align="right">
                    Bahagian Sumber Manusia 2019 &copy;
                </p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                             <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="200" height="250">
                        </div>
                    </div>
                    <h4 align="center"> <?= strtoupper($biodata->gelaran->Title) . " " . $biodata->CONm; ?></h4>

                    <ul class="list-unstyled user_data">

                        <li>
                            <i class="fa fa-phone-square user-profile-icon"></i> <?= $biodata->COHPhoneNo; ?>
                        </li> 
                        <li>
                            <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?>
                        </li>

                        <li><i class="fa fa-map-marker user-profile-icon"></i> 

                            <?php
                            if ($biodata->alamatTetap) {
                                echo $biodata->alamat->alamatPenuh;
                            } else if ($biodata->alamatSuratmenyurat) {
                                echo $biodata->alamat->alamatPenuh;
                            } else {
                                echo $biodata->alamat->alamatPenuh;
                            }
                            ?>
                        </li>

                    </ul>
                    <br/>


                    <?php
                    $bahasa = $biodata->bahasa;
                    if ($bahasa) {
                        ?>
                        <h2><i class="fa fa-flag" aria-hidden="true"></i> Kemahiran Bahasa</h2>   
                        <?php
                        foreach ($bahasa as $bahasa) {
                            ?>
                            <p align="center"><b><?= $bahasa->namaBahasa->Lang; ?></b></p>
                            <ul class="list-unstyled user_data">
                                <li>
                                    <p>Kemahiran Lisan</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar" style="background-color: #2A3F54;" role="progressbar" data-transitiongoal="<?= $bahasa->TahapKemahiran($bahasa->LangSkillOral); ?>"></div>
                                    </div>
                                </li>
                                <li>
                                    <p>Kemahiran Menulis</p>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar" style="background-color: #2A3F54;" role="progressbar" data-transitiongoal="<?= $bahasa->TahapKemahiran($bahasa->LangSkillWritten); ?>"></div>
                                    </div>
                                </li> 
                            </ul>
                            <?php
                        }
                    }
                    ?> 
                    <br/>

                    <?php if ($biodata->statLantikan != 1) { ?>
                        <?php $interval = date_diff(new DateTime("now"), date_create($biodata->endDateLantik)); ?>
                        <h2><i class="fa fa-flag" aria-hidden="true"></i> Baki Bon / Ikatan Kontrak  </h2>   
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <tr>
                                <th colspan="6" class="text-center">Tempoh</th>
                            </tr>
                            <tr>
                                <td>Tahun: </td>
                                <th><?= $interval->format('%y'); ?></th>
                                <td>Bulan: </td>
                                <th><?= $interval->format('%m'); ?></th>
                                <td>Hari: </td>
                                <th><?= $interval->format('%d'); ?></th> 
                            </tr>
                        </table> 
                    <?php } ?>

                    <br/>
                    <?php
                    $badanprof = $biodata->badanprof;
                    if ($badanprof) {
                        ?>
                        <h2><i class="fa fa-certificate" aria-hidden="true"></i> Badan Profesional </h2>   
                        <table class="table table-borderless">
                            <?php
                            $i = 0;
                            foreach ($badanprof as $badanprof) {
                                ?>  
                                <tr>
                                    <th><b> <?= $i = $i + 1; ?>. </b> </th>
                                    <th class="col-sm-1 col-md-1 col-xs-1">Badan Profesional</th>  
                                    <td><?= $badanprof->nambadanprofesional; ?></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Taraf Keahlian</th>  
                                    <td><?= $badanprof->tarkeahlian; ?></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Tarikh Mula Menyertai</th>  
                                    <td><?php
                                        if ($badanprof->tarikhmula == null) {
                                            echo $biodata->getTarikh($badanprof->tarikhmula);
                                        } else {
                                            echo 'Tiada Maklumat';
                                        }
                                        ?></td>
                                </tr> 
                                <?php
                            }
                            ?>  
                        </table>
                    <?php } ?>
                    <br/>

                        <?php if ($biodata->persidangan) { ?> 
                            <h2><i class="fa fa-list-alt" aria-hidden="true"></i> Persidangan</h2>
                            <div class="table-responsive">
                            <table class="table table-sm table-bordered jambo_table table-striped"> 
                                    <tr>
                                        <td> 
                                            <?= Html::a('Persidangan', ['pemohon/persidangan'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                            </table>
                            </div>
                        <?php } ?>
                        
                        <?php if($biodata->jawatan->job_group==1) { ?> 
                        <br/> 
                        <h2><i class="fa fa-list-alt" aria-hidden="true"></i> Penerbitan </h2>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered jambo_table table-striped">
                                <?php if ($biodata->abstract) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Absract', ['pemohon/penerbitan', 'type' => 'abstract'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->anthology) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Anthology', ['pemohon/penerbitan', 'type' => 'anthology'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->book) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Book', ['pemohon/penerbitan', 'type' => 'book'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->bookChapter) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Book Chapter', ['pemohon/penerbitan', 'type' => 'bookChapter'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->creative) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Creative', ['pemohon/penerbitan', 'type' => 'creative'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->journalInternational) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Journal International', ['pemohon/penerbitan', 'type' => 'journalInternational'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->journalNational) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Journal National', ['pemohon/penerbitan', 'type' => 'journalNational'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->magazine) { ?>
                                    <tr>
                                        <td>
                                            <?= Html::a('Magazine', ['pemohon/penerbitan', 'type' => 'magazine'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->manual) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Manual', ['pemohon/penerbitan', 'type' => 'manual'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->module) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Module', ['pemohon/penerbitan', 'type' => 'module'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->preUni) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('PreUniversiti', ['pemohon/penerbitan', 'type' => 'preUni'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->proceedingInternational) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Proceeding International', ['pemohon/penerbitan', 'type' => 'proceedingInternational'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->proceedingNational) { ?>
                                    <tr>
                                        <td>
                                            <?= Html::a('Proceeding National', ['pemohon/penerbitan', 'type' => 'proceedingNational'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->technical) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Technical', ['pemohon/penerbitan', 'type' => 'technical'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->textbook) { ?>
                                    <tr>
                                        <td>
                                            <?= Html::a('Textbook', ['pemohon/penerbitan', 'type' => 'textbook'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($biodata->translation) { ?>
                                    <tr>
                                        <td> 
                                            <?= Html::a('Translation', ['pemohon/penerbitan', 'type' => 'translation'], ['class' => 'btn btn-link']); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <br/> 
                        <?php } ?>

                    <?php
                    $rujukan = $biodata->rujukan;
                    if ($rujukan) {
                        ?>
                        <h2><i class="fa fa-user" aria-hidden="true"></i> Rujukan </h2>   
                        <table class="table table-borderless text-center">
                            <?php if ($rujukan->peraku) { ?>
                                <tr>
                                    <td><p style="font-size:12px;">
                                            <b><?= $rujukan->peraku->CONm; ?> (PPP)</b><br/> 
                                                <?= $rujukan->peraku->displayJawatan; ?><br/></i>
                                            <b>
                                                <i class="fa fa-phone-square user-profile-icon"></i><?= $rujukan->peraku->COHPhoneNo; ?><br/> 
                                                <i class="fa fa-envelope user-profile-icon"></i> <?= $rujukan->peraku->COEmail; ?> 
                                            </b> 
                                        </p>
                                    </td>
                                </tr> 
                                <?php
                            }
                            if ($rujukan->pelulus) {
                                ?>
                                <tr>
                                    <td><p style="font-size:12px;">
                                            <b><?= $rujukan->pelulus->CONm; ?> (PPK)</b><br/> 
                                                <?= $rujukan->pelulus->displayJawatan; ?><br/></i>
                                            <b>
                                                <i class="fa fa-phone-square user-profile-icon"></i><?= $rujukan->pelulus->COHPhoneNo; ?><br/> 
                                                <i class="fa fa-envelope user-profile-icon"></i> <?= $rujukan->pelulus->COEmail; ?> 
                                            </b> 
                                        </p>
                                    </td>
                                </tr>
                            <?php } ?>


                        </table>
                    <?php } ?>

                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="profile_title">
                        <div class="col-md-6">
                            <h2>Maklumat Peribadi</h2>
                        </div>
                        <div class="col-md-6">
                            <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span><?= $biodata->last_update; ?></span>  
                            </div>
                        </div>
                    </div><br/>
                    <!-- start of user-activity-graph -->
                    <div style="width:100%; height:280px;">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <table class="table">

                                <tr>
                                    <th class="col-md-2">No. KP / Paspot</th>
                                    <td class="col-md-10"><?= $biodata->ICNO; ?></td> 
                                </tr>

                                <tr>
                                    <th>Status Kewarganegaraan</th>
                                    <td><?= $biodata->statusWarganegara->NatStatus; ?></td> 
                                </tr>

                                <tr>
                                    <th>Negara Kelahiran</th>
                                    <td><?= $biodata->negaraLahir->Country; ?></td> 
                                </tr>

                                <tr>
                                    <th>Umur</th>
                                    <td>
                                        <?php
                                        echo date("Y") - date("Y", strtotime($biodata->COBirthDt));
                                        ?>
                                    </td> 
                                </tr>

                                <tr>
                                    <th>Agama</th>
                                    <td><?= $biodata->agama->Religion; ?></td> 
                                </tr>

                                <tr>
                                    <th>Jantina</th>
                                    <td><?= $biodata->jantina->Gender; ?></td> 
                                </tr>

                                <tr>
                                    <th>Bangsa</th>
                                    <td><?= $biodata->bangsa->Race; ?></td> 
                                </tr>

                                <tr>
                                    <th>Etnik</th>
                                    <td><?= $biodata->etnik->Ethnic; ?></td> 
                                </tr>

                                <tr>
                                    <th>Jenis Darah</th>
                                    <td><?= $biodata->jenisDarah->BloodType; ?></td> 
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td><?= $biodata->tarafPerkahwinan->MrtlStatus; ?></td> 
                                </tr> 
                            </table> 
                            <br/><br/>

                        </div>

                        <?php
                        $lesen = $biodata->lesen;
                        if ($lesen) {
                            ?>
                            <div class="col-md-7 col-sm-7 col-xs-12"> 
                                <div class="x_panel"> 
                                    <div class="x_title">
                                        <h2>Lesen</h2><p align="right"><i class="fa fa-address-card-o" aria-hidden="true"></i></p>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content"> 
                                        <div class="col-md-12">
                                            <table class="table table-striped jambo_table">
                                                <tr class="headings">
                                                    <th class="col-md-2">No. Lesen</th>
                                                    <td class="col-md-2"><?= $lesen->LicNo ?></td>
                                                </tr> 
                                                <tr>
                                                    <th>Jenis Lesen</th>
                                                    <td><?= $lesen->jenisLesen->LicType ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kelas Lesen</th>
                                                    <td><?= $lesen->kelasLesen->LicClass ?></td>
                                                </tr>  
                                                <tr>
                                                    <th>Tarikh Dikeluarkan</th> 
                                                    <td><?php
                                                        if ($lesen->FirstLicIssuedDt == "0000-00-00") {
                                                            echo 'Tiada Maklumat';
                                                        } else {
                                                            echo $biodata->getTarikh($lesen->FirstLicIssuedDt);
                                                        }
                                                        ?> 
                                                    </td>
                                                </tr>  
                                                <tr>
                                                    <th>Tarikh Luput</th> 
                                                    <td><?php
                                                        if ($lesen->LicExpiryDt == "0000-00-00") {
                                                            echo 'Tiada Maklumat';
                                                        } else {
                                                            echo $biodata->getTarikh($lesen->LicExpiryDt);
                                                        }
                                                        ?> 
                                                    </td>
                                                </tr> 
                                            </table>
                                        </div> 
                                    </div>  
                                </div> 
                            </div>
                        <?php } ?> 

                        <?php
                        $kecacatan = $biodata->kecacatan;
                        if ($kecacatan) {
                            ?>
                            <div class="col-md-7 col-sm-7 col-xs-12"> 
                                <div class="x_panel"> 
                                    <div class="x_title">
                                        <h2>Kecacatan </h2><p align="right"><i class="fa fa-wheelchair" aria-hidden="true"></i></p>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <?php foreach ($kecacatan as $kecacatan) { ?>
                                            <div class="col-md-12">
                                                <table class="table table-striped jambo_table">
                                                    <tr class="headings">
                                                        <th class="col-md-2">No. Fail Kebajikan</th>
                                                        <td class="col-md-2"    ><?= $kecacatan->SocialWelfareNo ? $kecacatan->SocialWelfareNo : 'Tiada Maklumat'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Laporan Doktor</th>
                                                        <td><?= $kecacatan->DrRptNo ? $kecacatan->DrRptNo : 'Tiada Maklumat'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jenis Kecacatan</th>
                                                        <td><?= $kecacatan->jenisKecacatan->DisabilityType; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Punca Kecacatan</th>
                                                        <td><?= $kecacatan->puncaKecacatan->DisabilityCause; ?></td>
                                                    </tr> 
                                                    <tr>
                                                        <th>Tarikh Kecacatan</th>
                                                        <td><?php
                                                            if ($kecacatan->DisabilityDt == "0000-00-00") {
                                                                echo 'Tiada Maklumat';
                                                            } else {
                                                                echo $biodata->getTarikh($kecacatan->DisabilityDt);
                                                            }
                                                            ?> 
                                                        </td> 
                                                    </tr> 


                                                    <tr>
                                                        <th>Tarikh Kemalangan</th>
                                                        <td><?php
                                                            if ($kecacatan->AccidentDt == "0000-00-00") {
                                                                echo 'Tiada Maklumat';
                                                            } else {
                                                                echo $biodata->getTarikh($kecacatan->AccidentDt);
                                                            }
                                                            ?> 
                                                        </td>  
                                                    </tr>

                                                    <tr>
                                                        <th>Tarikh Sembuh</th>
                                                        <td><?php
                                                            if ($kecacatan->HealDt == "0000-00-00") {
                                                                echo 'Tiada Maklumat';
                                                            } else {
                                                                echo $biodata->getTarikh($kecacatan->HealDt);
                                                            }
                                                            ?> 
                                                        </td> 
                                                    </tr>

                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>  
                                </div> 
                            </div>
                        <?php } ?> 
                    </div>

                    <?php
                    $akademik = $biodata->akademik;
                    if ($akademik) {
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                            <div class="profile_title">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>Akademik </h2>
                                </div> 
                            </div><br/>
                            <ul class="list-unstyled timeline widget">
                                <?php
                                foreach ($akademik as $akademik) {
                                    ?> 
                                    <li><div class="block">
                                            <div class="block-content">
                                                <h2 class="title"><?= $akademik->EduCertTitle . ', ' . $akademik->institut->InstNm; ?></h2>
                                                <div class="byline">
                                                    <big><span>Tarikh Graduasi: </span> <a><?= $biodata->getTarikh($akademik->ConfermentDt); ?></a></big>
                                                </div>
                                                <div class="excerpt"> <b>Gred:</b> <?= $akademik->OverallGrade ? $akademik->OverallGrade : 'Tiada Maklumat'; ?> </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>   
                        </div>
                    <?php } ?>

                    <?php
                    $keluarga = $biodata->keluarga;
                    if ($keluarga) {
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                            <div class="profile_title">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-users" aria-hidden="true"></i> Maklumat Keluarga </h2>
                                </div> 
                            </div><br/>  
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                    <tr>
                                        <th>Bil</th>
                                        <th colspan="2" class="text-center">Butiran Keluarga</th> 
                                        <th colspan="2" class="text-center">Maklumat Pekerjaan</th> 
                                    </tr> 
                                    <?php
                                    $counter = 0;
                                    foreach ($keluarga as $keluarga) {
                                        $counter = $counter + 1;
                                        ?> 

                                        <tr>
                                            <td rowspan="3"><?= $counter; ?></td>
                                            <th>Nama</th> 
                                            <td><?= $keluarga->FmyNm; ?> </td> 
                                            <?php if ($keluarga->FmyEmployerNm) { ?>
                                                <th>Nama Majikan</th> 
                                                <td><?= $keluarga->FmyEmployerNm ? $keluarga->FmyEmployerNm : 'Tidak Berkaitan'; ?></td>
                                            <?php } else { ?>
                                                <th rowspan="3" colspan="2"> <br/><br/><div class="text-center">Tidak Berkaitan</div></th>
                                        <?php } ?>
                                        </tr>

                                        <tr> 
                                            <th>Hubungan</th>
                                            <td><?= $keluarga->hubunganKeluarga->RelNm; ?></td> 
                                            <?php if ($keluarga->CorpBodyTypeCd) { ?>
                                                <th>Jenis Majikan</th> 
                                                <td><?= $keluarga->CorpBodyTypeCd ? $keluarga->jenisBadanMajikan->CorpBodyType : 'Tidak Berkaitan'; ?></td> 
                                            <?php } ?>
                                        </tr> 
                                        <tr> 
                                            <th>Jantina</th> 
                                            <td><?= $keluarga->jantina->Gender; ?></td>   
                                            <?php if ($keluarga->OccSectorCd) { ?>
                                                <th>Sektor Pekerjaan</th>  
                                                <td><?= $keluarga->OccSectorCd ? $keluarga->sektorPekerjaan->OccSector : 'Tidak Berkaitan'; ?></td> 
                                            <?php } ?>
                                        </tr> 

                                    <?php } ?>
                                </table>
                            </div>
                        </div> 
                    <?php } ?>

                    <?php
                    $pengalaman = $biodata->pengalaman;
                    if ($pengalaman) {
                        ?>
                        <div class="col-md-12 col-sm-12 col-xs-12"> 
                            <div class="profile_title">
                                <div class="col-md-12">
                                    <h2><i class="fa fa-briefcase" aria-hidden="true"></i> Pengalaman Kerja </h2>
                                </div> 
                            </div><br/>  
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 
                                    <tr>
                                        <th>Bil</th>
                                        <th colspan="4" class="text-center">Butiran Pengalaman</th> 
                                    </tr> 
                                    <?php
                                    $counter = 0;
                                    foreach ($pengalaman as $pengalaman) {
                                        $counter = $counter + 1;
                                        ?> 

                                        <tr>
                                            <td rowspan="3"><?= $counter; ?></td>
                                            <th>Nama Majikan</th> 
                                            <td colspan="3"><?= $pengalaman->OrgNm ? $pengalaman->OrgNm : 'Tiada'; ?></td>

                                        </tr>

                                        <tr> 
                                            <th>Sektor</th> 
                                            <td> <?= $pengalaman->OccSectorCd ? $pengalaman->sektorPekerjaan->OccSector : 'Tiada Maklumat'; ?> </td>    
                                            <th>Tarikh Mula</th>
                                            <td><?php
                                                if ($pengalaman->PrevEmpStartDt == "0000-00-00") {
                                                    echo 'Tiada Maklumat';
                                                } else {
                                                    echo $biodata->getTarikh($pengalaman->PrevEmpStartDt);
                                                }
                                                ?> 
                                            </td>

                                        </tr>

                                        <tr> 
                                            <th>Jenis Majikan</th>   
                                            <td> <?= $pengalaman->CorpBodyTypeCd ? $pengalaman->jenisBadanMajikan->CorpBodyType : 'Tiada Maklumat'; ?> </td>
                                            <th>Tarikh Berhenti</th>
                                            <td><?php
                                                if ($pengalaman->PrevEmpEndDt == "0000-00-00") {
                                                    echo 'Tiada Maklumat';
                                                } else {
                                                    echo $biodata->getTarikh($pengalaman->PrevEmpEndDt);
                                                }
                                                ?> 
                                            </td>
                                        </tr> 

                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div> 
                    <?php } ?>

                </div>  
            </div> 
            <p align ="right">
                <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
            </p>
        </div>
    </div>
</div>  