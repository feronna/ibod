<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

use yii\helpers\Html;
?> 
 

    <div class="clearfix"></div>
 
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
                        <div class="profile_img">
                            <div id="crop-avatar">  
                                <img src="http://ejobs.ums.edu.my/ejobs/web/uploads/ejobs/gambar/<?= $biodata->profileImg($biodata->ICNO) ?>" width="200" height="250">
                            </div>
                        </div>
                        <h2 align="center"> <?= strtoupper($biodata->gelaran->Title) . " " . strtoupper($biodata->CONm); ?> </h2>

                        <ul class="list-unstyled user_data">

                            <li>
                                <i class="fa fa-phone-square user-profile-icon"></i> <?= $biodata->COHPhoneNo; ?>
                            </li> 
                            <li>
                                <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?>
                            </li>

                            <li><i class="fa fa-map-marker user-profile-icon"></i> <?php if($alamat) { echo $alamat->alamatPenuh;} else{ echo 'Tiada Maklumat';} ?>
                            </li>

                        </ul>
                        <br/>

                        <h2><i class="fa fa-flag" aria-hidden="true"></i> Kemahiran Bahasa</h2>   
                        <?php
                        if ($bahasa) {
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
                        <p align="right"></p>
                        <?php if ($kelayakanProf) { ?>
                            <h2><i class="fa fa-certificate" aria-hidden="true"></i> Kelayakan Profesional </h2>   
                            <table class="table table-borderless">
                                <?php
                                $i = 0;
                                if ($kelayakanProf) {
                                    foreach ($kelayakanProf as $kelayakanProf) {
                                        ?>  
                                        <tr>
                                            <th><b> <?= $i = $i + 1; ?>. </b> </th>
                                            <th class="col-sm-1 col-md-1 col-xs-1">Nama Sijil</th>  
                                            <td><?= $kelayakanProf->sijil_nama; ?></td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>Nama Badan/ Organisasi</th>  
                                            <td><?= $kelayakanProf->sijil_bdnOrganisasi; ?></td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>Tarikh Sijil</th>  
                                            <td><?= $biodata->getTarikh($kelayakanProf->sijil_tarikh); ?></td>
                                        </tr> 
                                        <?php
                                    }
                                }
                                ?>  
                            </table>
                        <?php } ?>

                        <br/>       
                        <?php if ($rujukan) { ?>
                            <h2><i class="fa fa-user" aria-hidden="true"></i> Rujukan</h2>   
                            <table class="table table-borderless text-center">
                                <?php
                                $i = 0;
                                foreach ($rujukan as $rujukan) {
                                    ?>   
                                    <tr> 
                                        <td><b> <?= $i = $i + 1; ?>. </b> </td> 
                                    </tr>
                                    <tr>
                                        <td><p style="font-size:12px;">
                                                <b><?= $rujukan->nama; ?></b><br/>
                                                <i><?= $rujukan->hubungan; ?><br/>
                                                    <?= $rujukan->jawatan; ?><br/></i>
                                                <b>
                                                    <i class="fa fa-phone-square user-profile-icon"></i><?= $rujukan->TelNo; ?><br/> 
                                                    <i class="fa fa-envelope user-profile-icon"></i> <?= $rujukan->Emel; ?> 
                                                </b> 
                                            </p>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td><b>Nama Majikan</b></td>   
                                    </tr>
                                    <tr> 
                                        <td><?= $rujukan->nama_majikan; ?></td> 
                                    </tr> 
                                    <tr> 
                                        <td><b>Alamat Majikan</b></td>  
                                    </tr>
                                    <tr> 
                                        <td><?= $rujukan->alamatPenuh; ?></td>   
                                    </tr>  
                                <?php } ?>  
                            </table>
                        <?php } ?>  
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                        <div class="profile_title">
                            <div class="col-md-6">
                                <h2>Maklumat Peribadi </h2>
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

                                    <tr>
                                        <th>Berat</th>
                                        <td><?= $biodata->CoWeight; ?></td> 
                                    </tr>

                                    <tr>
                                        <th>Tinggi</th>
                                        <td><?= $biodata->CoHeight; ?></td> 
                                    </tr>


                                    <tr>
                                        <th>BMI</th>
                                        <td><?= $biodata->COBmiLvl . ' (' . $biodata->COBmiIndex . ')'; ?></td> 
                                    </tr>
                                </table> 
                                <br/><br/>
                                
                                
                                
                            </div>


                            <div class="col-md-7 col-sm-7 col-xs-12"> 
                                <div class="x_panel">
                                    <?php if ($kecacatan) { ?>
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
                                                            <td class="col-md-2"    ><?= $kecacatan->SocialWelfareNo; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>No. Laporan Doktor</th>
                                                            <td><?= $kecacatan->DrRptNo; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Jenis Kecacatan</th>
                                                            <td><?= $kecacatan->jenisKecacatan->DisabilityType; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Punca Kecacatan</th>
                                                            <td><?= $kecacatan->puncaKecacatan->DisabilityCause; ?></td>
                                                        </tr>
                                                        <?php if ($kecacatan->DisabilityDt) { ?>
                                                            <tr>
                                                                <th>Tarikh Kecacatan</th>
                                                                <td><?= $biodata->getTarikh($kecacatan->DisabilityDt); ?></td>
                                                            </tr>
                                                            <?php
                                                        }

                                                        if ($kecacatan->HealDt) {
                                                            ?>
                                                            <tr>
                                                                <th>Tarikh Sembuh</th>
                                                                <td><?= $biodata->getTarikh($kecacatan->HealDt); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                            <?php } ?>
                                        </div> 
                                    <?php } ?>
                                    <?php if($lainlain) { ?>
                                    <div class="x_title">
                                        <h2>Maklumat Tambahan </h2><p align="right"><i class="fa fa-th-list" aria-hidden="true"></i></p>

                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <div class="x_content">
                                        <div class="col-md-12">
                                            <table class="table table-striped jambo_table"> 
                                                <tr>
                                                    <th class="col-md-2">Kesanggupan Merantau</th>
                                                    <td class="col-md-2"><?= $lainlain->Status($lainlain->status_merantau); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kesanggupan Berpindah</th>
                                                    <td><?= $lainlain->Status($lainlain->status_berpindah); ?></td>
                                                </tr> 
                                                <tr>
                                                    <th>Gaji Bulanan Dipohon (RM)</th>
                                                    <td><?= $lainlain->exp_gaji; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tarikh Boleh Mula Bekerja</th>
                                                    <td><?= $biodata->getTarikh($lainlain->tarikh_mula_bekerja); ?></td>
                                                </tr> 
                                            </table> 
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if ($bonKontrak) { ?>
                                        <div class="x_title">
                                            <h2>Bon Kontrak </h2><p align="right"><i class="fa fa-file-text" aria-hidden="true"></i></p>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content"> 
                                            <div class="col-md-12">
                                                <table class="table table-striped jambo_table">
                                                    <tr class="headings">
                                                        <th class="col-md-2">Nama Organisasi</th>
                                                        <td class="col-md-2"    ><?= $bonKontrak->nama_organisasi; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tempoh Bon/Ikatan  (Tahun)</th>
                                                        <td><?= $bonKontrak->tempoh_bon; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Baki Bon/Ikatan </th>
                                                        <td><?= $bonKontrak->baki_bon; ?></td>
                                                    </tr> 
                                                </table>
                                            </div> 
                                        </div> 
                                    <?php } ?>
                                </div>



                            </div>
                        </div>


                        <?php if ($pengajianTinggi) { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="profile_title">
                                    <div class="col-md-12">
                                        <h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>Akademik - Pengajian Tinggi </h2>
                                    </div> 
                                </div><br/>
                                <ul class="list-unstyled timeline widget">
                                    <?php
                                    foreach ($pengajianTinggi as $pengajianTinggi) {
                                        ?> 
                                        <li><div class="block">
                                                <div class="block-content">
                                                    <h2 class="title"><?= $pengajianTinggi->EduCertTitle . ', ' . $pengajianTinggi->namainstitut . $pengajianTinggi->InstNm; ?></h2>
                                                    <div class="byline">
                                                        <big><span>Tarikh Graduasi: </span> <a><?= $biodata->getTarikh($pengajianTinggi->ConfermentDt); ?></a></big>
                                                    </div>
                                                    <div class="excerpt"> <b>CGPA:</b> <?= $pengajianTinggi->OverallGrade; ?> </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>   
                            </div>
                        <?php } ?>

                        <?php if ($peringkatSekolah) { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="profile_title">
                                    <div class="col-md-12">
                                        <h2><i class="fa fa-graduation-cap" aria-hidden="true"></i>Akademik - Peringkat Sekolah </h2>
                                    </div> 
                                </div><br/>
                                <ul class="list-unstyled timeline widget">
                                    <?php
                                    foreach ($peringkatSekolah as $peringkatSekolah) {
                                        ?> 
                                        <li><div class="block">
                                                <div class="block-content">
                                                    <h2 class="title"><?= $peringkatSekolah->EduSchool; ?></h2>
                                                    <div class="byline">
                                                        <big>Tahun Graduasi<span> : <?= $peringkatSekolah->EduYear; ?> </span> <a> </a></big>
                                                    </div> 
                                                </div>
                                            </div>
                                        </li> 
                                    <?php } ?>
                                </ul>   
                            </div>
                        <?php } ?>

                        <?php
                        if ($keluarga) {
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12"> 
                                <div class="profile_title">
                                    <div class="col-md-12">
                                        <h2><i class="fa fa-briefcase" aria-hidden="true"></i> Maklumat Keluarga </h2>
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
                                                <td rowspan="5"><?= $counter; ?></td>
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
                                                <th>No KP / Paspot</th> 
                                                <td><?= $keluarga->FamilyId; ?></td>   
                                                <?php if ($keluarga->OccSectorCd) { ?>
                                                    <th>Sektor Pekerjaan</th>  
                                                    <td><?= $keluarga->OccSectorCd ? $keluarga->sektorPekerjaan->OccSector : 'Tidak Berkaitan'; ?></td> 
                                                <?php } ?>
                                            </tr> 
                                            <tr> 
                                                <th>Tarikh Lahir</th> 
                                                <td><?= $keluarga->FmyBirthDt; ?></td>  
                                                <th colspan="2" class="text-center">Status Kecacatan</th>  
                                            </tr>
                                            <tr> 
                                                <th>Jantina</th> 
                                                <td><?= $keluarga->jantina->Gender; ?></td>  
                                                <td colspan="2" class="text-center"><?= $keluarga->disabilityStatus; ?></td> 
                                            </tr>

                                        <?php } ?>
                                    </table>
                                </div>
                            </div> 
                        <?php } ?>

                        <?php if($pengalaman) { ?>
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
                                        <th colspan="2" class="text-center">Butiran Pengalaman</th>
                                        <th colspan="2" class="text-center">Jawatan</th>
                                        <th colspan="2" class="text-center">Gaji</th>
                                        <th colspan="2" class="text-center">Tarikh</th>  
                                    </tr> 
                                    <?php
                                    $counter = 0;
                                    foreach ($pengalaman as $pengalaman) {
                                        $counter = $counter + 1;
                                        ?> 

                                        <tr>
                                            <td rowspan="5"><?= $counter; ?></td>
                                            <th>Nama Majikan</th> 
                                            <td><?= $pengalaman->OrgNm; ?></td>
                                            <th>Nama Jawatan</th>
                                            <td><?= $pengalaman->PrevJobPost; ?></td>
                                            <th>Gaji Bulanan Terakhir(RM)</th>
                                            <td><?= $pengalaman->PrevSlry; ?></td>
                                            <th>Tarikh Mula</th>
                                            <td><?= $biodata->getTarikh($pengalaman->PrevEmpStartDt); ?></td>  
                                        </tr>

                                        <tr> 
                                            <th>Sektor</th>
                                            <td><?= $pengalaman->sektorPekerjaan->OccSector; ?></td>
                                            <th rowspan="2">Peringkat Jawatan</th>
                                            <td rowspan="2"><?= $pengalaman->PrevPostLvl; ?></td>
                                            <th rowspan="2">Elaun Bulanan(RM)</th>
                                            <td rowspan="2"><?= $pengalaman->PrevElaun; ?></td>
                                            <th>Tarikh Berhenti</th>
                                            <td>
                                                <?php
                                                if($pengalaman->PrevEmpEndDt){
                                                    echo $pengalaman->tarikh($pengalaman->PrevEmpEndDt);
                                                }
                                                ?>
                                            </td>
                                        </tr>

                                        <tr> 
                                            <th>Jenis Majikan</th> 
                                            <td><?= $pengalaman->jenisBadanMajikan->CorpBodyType; ?></td>   
                                            <th>Tarikh Kenaikan Gaji Terakhir</th> 
                                            <td><?= $biodata->getTarikh($pengalaman->PrevDateSlryInc); ?></td> 
                                        </tr>

                                        <tr>
                                            <th colspan="4" class="text-center">Alamat Majikan</th> 
                                            <th colspan="4" class="text-center">Alasan Berhenti</th> 
                                        </tr> 
                                        <tr> 
                                            <td colspan ="4" class="text-center"><?= $pengalaman->alamatPenuh; ?></td> 
                                            <td colspan ="4" class="text-center"><?= $pengalaman->ReasonEndPrev; ?></td>
                                        </tr> 

                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <?php } ?>

                        <?php
                        $persidangan = $biodata->persidangan;
                        if ($persidangan) {
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12"> 

                                <div class="profile_title">
                                    <div class="col-md-12">
                                        <h2><i class="fa fa-briefcase" aria-hidden="true"></i> Persidangan</h2>  
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered jambo_table table-striped"> 

                                        <tr>
                                            <th>Bil</th>
                                            <th colspan="8" class="text-center">Butiran</th> 
                                        </tr>  
                                        <?php
                                        if ($persidangan) {
                                            $counter = 0;
                                            foreach ($persidangan as $persidangan) {
                                                $counter = $counter + 1;
                                                ?> 

                                                <tr>
                                                    <td rowspan="4"><?= $counter; ?></td>
                                                    <th>Tajuk Persidangan</th> 
                                                    <td colspan="7"><?= $persidangan->ConferenceTitle ? $persidangan->ConferenceTitle : 'Tiada'; ?></td>
                                                </tr>

                                                <tr> 
                                                    <th>Tajuk Kertas</th> 
                                                    <td colspan="5"> <?= $persidangan->PaperworkTitle ? $persidangan->PaperworkTitle : 'Tiada Maklumat'; ?> </td>    
                                                    <th>Tarikh Mula</th>
                                                    <td><?php
                                                        if ($persidangan->StartDate == "0000-00-00") {
                                                            echo 'Tiada Maklumat';
                                                        } else {
                                                            echo $biodata->getTarikh($persidangan->StartDate);
                                                        }
                                                        ?> 
                                                    </td>

                                                </tr>

                                                <tr> 
                                                    <th>Peringkat</th> 
                                                    <td colspan="2"><?= $persidangan->ConfLevel ? $persidangan->ConfLevel : 'Tiada'; ?></td> 
                                                    <th>Peranan</th> 
                                                    <td colspan="2"><?= $persidangan->Role ? $persidangan->Role : 'Tiada'; ?></td>
                                                    <th>Tarikh Berakhir</th>
                                                    <td><?php
                                                        if ($persidangan->EndDate == "0000-00-00") {
                                                            echo 'Tiada Maklumat';
                                                        } else {
                                                            echo $biodata->getTarikh($persidangan->EndDate);
                                                        }
                                                        ?> 
                                                    </td>
                                                </tr> 

                                                <tr>
                                                    <th>Tempat</th>   
                                                    <td colspan="7"> <?= $persidangan->Place ? $persidangan->Place : 'Tiada Maklumat'; ?> </td>

                                                </tr>

                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <tr>
                                                <td colspan="9" class="text-center">Tiada Rekod</td>                     
                                            </tr>
                                        <?php }
                                        ?>
                                    </table>
                                </div> 
                            </div> 
                        <?php } ?>


                        <?php
                        $penerbitan = $biodata->penerbitan;
                        if ($penerbitan) {
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12"> 

                                <div class="profile_title">
                                    <div class="col-md-12">
                                        <h2><i class="fa fa-briefcase" aria-hidden="true"></i> Penerbitan</h2>  
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered jambo_table table-striped"> 

                                        <tr>
                                            <th>Bil</th>
                                            <th colspan="4" class="text-center">Butiran Penerbitan</th> 
                                        </tr>  

                                        <?php
                                        if ($penerbitan) {
                                            $counter = 0;
                                            foreach ($penerbitan as $penerbitan) {
                                                $counter = $counter + 1;
                                                ?> 

                                                <tr>
                                                    <td rowspan="4"><?= $counter; ?></td>
                                                    <th>Tajuk</th> 
                                                    <td colspan="3"><?= $penerbitan->tajuk ? $penerbitan->tajuk : 'Tiada'; ?></td>
                                                </tr>

                                                <tr> 
                                                    <th>Penerbit</th> 
                                                    <td> <?= $penerbitan->penerbit ? $penerbitan->penerbit : 'Tiada Maklumat'; ?> </td>    
                                                    <th>Tahun Penerbitan</th>
                                                    <td><?= $penerbitan->tahun_penerbitan ? $penerbitan->tahun_penerbitan : 'Tiada'; ?></td>  

                                                </tr>

                                                <tr> 
                                                    <th>Peringkat</th> 
                                                    <td><?= $penerbitan->penLevel ? $penerbitan->penLevel : 'Tiada'; ?></td> 
                                                    <th>Peranan</th> 
                                                    <td><?= $penerbitan->role ? $penerbitan->role : 'Tiada'; ?></td> 
                                                </tr> 

                                                <tr>
                                                    <th>Tempat</th>   
                                                    <td colspan="3"> <?= $penerbitan->tempat_penerbitan ? $penerbitan->tempat_penerbitan : 'Tiada Maklumat'; ?> </td>

                                                </tr>

                                                <?php
                                            }
                                        } else {
                                            ?>

                                            <tr>
                                                <td colspan="9" class="text-center">Tiada Rekod</td>                     
                                            </tr>
                                        <?php }
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