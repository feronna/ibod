<!DOCTYPE html> 
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body> 
        <p align="center"><img src="images/logo-umsblack-text-png.png" width="150px" height="auto"/> </p><br/> 
        <?php echo $this->render('main_cv', ['biodata' => $biodata]); ?>  
        <h5><b>1.2 ACTUAL POST</b></h5>
        <table class="table" style="width:100%;"> 
            <tbody>
                <tr> 
                    <th style="width:16%">Grade</th>
                    <td style="width:16%"><?= $biodata->jawatan->gred; ?></td> 
                    <th style="width:17%">
                        Permanent Appointment <br/>
                        Period at UMS
                    </th>
                    <td style="width:17%">
                        <?php
                        if ($biodata->statLantikan == 1) {//tetap
                            echo $biodata->servPeriodPermanentBI;
                        } else {
                            echo '-';
                        }
                        ?>
                    </td> 
                    <th style="width:17%">Date Assigned</th>
                    <td style="width:17%"><?php
                        if ($biodata->statLantikan == 1) {//tetap
                            echo $biodata->SandanganCTetap ? $biodata->getTarikhBI($biodata->SandanganCTetap->start_date) : '-';
                        } else {
                            echo $biodata->sandanganCKontrak ? $biodata->getTarikhBI($biodata->sandanganCKontrak->start_date) : '-';
                        }
                        ?></td> 
                </tr>
                <tr> 
                    <th>Designation</th>
                    <td><?= $biodata->jawatan->fname; ?></td>  
                    <th>
                        Current Positions <br/>
                        Held Period
                    </th>
                    <td><?= $biodata->servPeriodCPositionBI; ?></td> 
                    <th>Confirmation date</th>
                    <td><?php
                        if ($biodata->confirmDt) {
                            echo $biodata->confirmDt ? $biodata->getTarikhBI($biodata->confirmDt->ConfirmStatusStDt) : '-';
                        } else {
                            echo '-';
                        }
                        ?></td> 
                </tr>
                <tr> 
                    <th>Status</th>
                    <td><?= $biodata->statusLantikan->ApmtStatusNm; ?></td> 
                    <th>
                        Date appointed to <br/>
                        current position
                    </th>
                    <td><?php
                        if ($biodata->statLantikan == 1) {//tetap
                            echo $biodata->SandanganCTetap ? $biodata->getTarikhBI($biodata->SandanganCTetap->start_date) : '-';
                        } else {
                            echo $biodata->sandanganCKontrak ? $biodata->getTarikhBI($biodata->sandanganCKontrak->start_date) : '-';
                        }
                        ?></td> 
                    <th>Location</th>
                    <td><?= $biodata->penempatan ? $biodata->penempatan->department->fullname : ' ' ?></td> 
                </tr> 
            </tbody>
        </table>
        <div style="break-after:page"></div>
        <h5><b>1.3 ADMINISTRATIVE POSITION</b></h5> 
        <?php if ($biodata->adminPosition) { ?>
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%;"> 
                    <?php
                    $bil1 = 1;
                    ?>
                    <thead> 
                        <tr class="info">
                            <th class="text-center" style="width: 15%;">Position</th> 
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" >Description</th>
                            <th class="text-center" style="width: 16%;">Department</th>
                            <th class="text-center" style="width: 12%;">Campus</th>
                            <th class="text-center" style="width: 15%;">Position Assigned</th>
                            <th class="text-center" style="width: 15%;">Date</th> 
    <!--                                            <th class="text-center">Files</th>-->
                        </tr>
                    </thead>
                    <?php foreach ($biodata->adminPosition as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $l->adminpos ? $l->adminpos->position_name : ''; ?></td> 
                            <td class="text-center"><?= $l->jobStatus0 ? $l->jobStatus0->jobstatus_desc : ''; ?></td>
                            <td class="text-center"><?= $l->description ? $l->description : ''; ?></td>
                            <td class="text-center"><?= $l->kakitangan->department ? $l->kakitangan->department->fullname : ''; ?></td>
                            <td class="text-center"><?= $l->campus ? $l->campus->campus_name : ''; ?></td>
                            <td class="text-center"><?= $l->appoinment_date ? $l->appoinment_date : ''; ?></td>
                            <td class="text-center">
                                <?= $l->start_date ? $l->start_date : ''; ?>-
                                <?= $l->end_date ? $l->end_date : ''; ?>
                            </td>
                            <!--<td class="text-center"><span style="color: red;">Different server</span></td>-->
                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
        } else {
            echo "- No information";
        }
        ?>

        <div style="break-after:page"></div>
        <h5><b>1.4 EDUCATIONAL BACKGROUND</b></h5> 
        <?php if ($biodata->akademik) { ?>
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%;">
                    <thead> 
                        <tr class="info"> 

                            <th>Year</th>
                            <th>Educational Level</th>
                            <th>Name of Certificate</th>
                            <th>Institute</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php
                        foreach ($biodata->akademik as $akademik) {
                            ?> 
                            <tr> 

                                <td><?= $biodata->getTarikhBI($akademik->ConfermentDt); ?></td>
                                <td><?= $akademik->pendidikanTertinggi ? $akademik->pendidikanTertinggi->HighestEduLevelBI : 'Tiada Maklumat'; ?></td>
                                <td><?= $akademik->EduCertTitleBI ? $akademik->EduCertTitleBI : 'Tiada Maklumat'; ?></td>
                                <td>
                                    <?php
                                    echo $akademik->EduCertTitle . ', ';
                                    if ($akademik->InstCd == 004) {
                                        echo 'Lain-Lain';
                                    } else {
                                        echo $akademik->institut ? $akademik->institut->InstNm : '';
                                    }
                                    ?>

                                </td>
                            </tr> 
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            echo "- No information";
        }
        ?>
        <div style="break-after:page"></div>
        <h5><b>1.5 PROFESIONAL EXPERTISE</b></h5> 
        <?php
        $kepakaran = $biodata->kepakaran;
        if ($kepakaran) {
            ?> 
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%;">
                    <thead> 
                        <tr class="info"> 
                            <th>No.</th>
                            <th style="width: 15%;">Group</th> 
                            <th>Area</th> 
                            <th style="width: 15%;">Date Approved</th>   
                        </tr>  
                    </thead>
                    <?php
                    $counter = 0;
                    foreach ($kepakaran as $kepakaran) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>
                            <td><?= $kepakaran->Groups ? $kepakaran->Groups : ' '; ?></td>
                            <td><?= $kepakaran->Area ? $kepakaran->Area : ''; ?></td> 
                            <td><?= $kepakaran->TarikhLulus ? DATE('Y-m-d', strtotime($kepakaran->TarikhLulus)) : ''; ?></td>   
                        </tr> 
                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
        } else {
            echo "- No information";
        }
        ?>  
        <div style="break-after:page"></div>
        <h5><b>1.6 HONOUR(S) & PROFESIONAL AWARD(S)</b></h5> 
        <?php if ($biodata->anugerah) { ?>
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%;">
                    <?php
                    $bil1 = 1;
                    ?> 
                    <thead> 
                        <tr class="info">
                            <th class="text-center" style="width: 15%;">Date</th>
                            <th class="text-center">From</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Award</th>  
                            <th class="text-center">Category</th>
                        </tr>
                    </thead> 
                    <?php foreach ($biodata->anugerah as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $l->AwdCfdDt ? $l->AwdCfdDt : ''; ?></td>
                            <td class="text-center"><?= $l->dianugerahkanOleh ? $l->dianugerahkanOleh->CfdBy : ''; ?></td> 
                            <td class="text-center"><?= $l->gelaran ? $l->gelaran->Title : ''; ?></td>
                            <td class="text-center"><?= $l->namaAnugerah ? $l->namaAnugerah->Awd : ''; ?></td> 
                            <td class="text-center"><?= $l->kategoriAnugerah ? $l->kategoriAnugerah->AwdCat : ''; ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>

            <?php
        } else {
            echo "- No information";
        }
        ?>
        <div style="break-after:page"></div>
        <h5><b>1.7 CAREER HISTORY</b></h5> 
        <?php
        $pengalaman = $biodata->pengalaman;
        if ($pengalaman) {
            ?>   
            <div class="table-responsive"> 
                <table class="table table-bordered" style="width:100%;"> 
                    <thead>
                        <tr class="info">
                            <th>No.</th> 
                            <th style="width: 15%;">Start Date</th>
                            <th style="width: 15%;">End Date</th>
                            <th>Position</th>  
                            <th>Sector</th> 
                            <th>Type</th>  

                        </tr> 
                    </thead> 
                    <?php
                    $counter = 0;
                    foreach ($pengalaman as $pengalaman) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>
                            <td><?php
                                if ($pengalaman->PrevEmpStartDt == "0000-00-00") {
                                    echo '';
                                } else {
                                    echo $pengalaman->PrevEmpStartDt;
                                }
                                ?> 
                            </td>  
                            <td><?php
                                if ($pengalaman->PrevEmpEndDt == "0000-00-00") {
                                    echo '';
                                } else {
                                    echo $pengalaman->PrevEmpEndDt;
                                }
                                ?> 
                            </td>
                            <td><?= $pengalaman->PrevEmpRemarks ? $pengalaman->PrevEmpRemarks : ''; ?></td> 
                            <td> <?= $pengalaman->OccSectorCd ? $pengalaman->sektorPekerjaan->OccSector : ''; ?> </td>    
                            <td> <?= $pengalaman->CorpBodyTypeCd ? $pengalaman->jenisBadanMajikan->CorpBodyType : ''; ?> </td> 
                        </tr> 

                        <?php
                    }
                    ?>
                </table>
            </div> 
            <?php
        } else {
            echo "- No information";
        }
        ?>
        <div style="break-after:page"></div>

        <h5><b>1.8 IDP POINT FOR THE PAST 3 YEARS</b></h5> 
        <div class="table-responsive"> 
            <table class="table table-bordered" style="width:100%;"> 
                <thead> 
                    <tr class="info">
                        <th class="text-center" style="width: 10%;">Year</th>  
                        <th class="text-center" style="width: 20%;">Minimum Point</th>  
                        <th class="text-center" style="width: 20%;">Point</th>   
                        <th>Status</th>   
                    </tr>
                </thead>
                <?php if ($biodata->jawatan->job_category == 1) { ?>
                    <tr>   
                        <?php
                        $year1 = $biodata->markahlnptCV(1, 'Tahun');
                        $model = $biodata->getIdpMinimum($biodata->ICNO, $year1);
                        ?> 
                        <td><?= $year1; ?></td>
                        <td><?= $model ? $model->idp_mata_min : '-'; ?></td>
                        <td><?= $model ? $model->jum_mata_dikira : '-'; ?></td>
                        <td><?= $biodata->getIdpStatus($model); ?></td>
                    </tr>
                    <tr>  
                        <?php
                        $year2 = $biodata->markahlnptCV(2, 'Tahun');
                        $model1 = $biodata->getIdpMinimum($biodata->ICNO, $year2);
                        ?> 
                        <td><?= $year2; ?></td>
                        <td><?= $model1 ? $model1->idp_mata_min : '-'; ?></td>
                        <td><?= $model1 ? $model1->jum_mata_dikira : '-'; ?></td>
                        <td><?= $biodata->getIdpStatus($model1); ?></td>
                    </tr>
                    <tr>   
                        <?php
                        $year3 = $biodata->markahlnptCV(3, 'Tahun');
                        $model2 = $biodata->getIdpMinimum($biodata->ICNO, $year3);
                        ?> 
                        <td><?= $year3; ?></td>
                        <td><?= $model2 ? $model2->idp_mata_min : '-'; ?></td>
                        <td><?= $model2 ? $model2->jum_mata_dikira : '-'; ?></td>
                        <td><?= $biodata->getIdpStatus($model2); ?></td>
                    </tr>
                <?php } else { ?> 
                    <tr>   
                        <?php
                        $year1 = $biodata->markahlnptCVpen(1, 'Tahun');
                        $model = $biodata->getIdpMinimum($biodata->ICNO, $year1);
                        ?> 
                        <td><?= $year1; ?></td>
                        <td><?= $model ? $model->idp_mata_min : '-'; ?></td>
                        <td><?= $model ? $model->jum_mata_dikira : '-'; ?></td>
                        <td><?= $biodata->getIdpStatus($model); ?></td>
                    </tr>
                    <tr>  
                        <?php
                        $year2 = $biodata->markahlnptCVpen(2, 'Tahun');
                        $model1 = $biodata->getIdpMinimum($biodata->ICNO, $year2);
                        ?> 
                        <td><?= $year2; ?></td>
                        <td><?= $model1 ? $model1->idp_mata_min : '-'; ?></td>
                        <td><?= $model1 ? $model1->jum_mata_dikira : '-'; ?></td>
                        <td><?= $biodata->getIdpStatus($model1); ?></td>
                    </tr>
                    <tr>   
                        <?php
                        $year3 = $biodata->markahlnptCVpen(3, 'Tahun');
                        $model2 = $biodata->getIdpMinimum($biodata->ICNO, $year3);
                        ?> 
                        <td><?= $year3; ?></td>
                        <td><?= $model2 ? $model2->idp_mata_min : '-'; ?></td>
                        <td><?= $model2 ? $model2->jum_mata_dikira : '-'; ?></td>
                        <td><?= $biodata->getIdpStatus($model2); ?></td>
                    </tr>
                <?php } ?> 
            </table>
        </div>


        <div style="break-after:page"></div>

        <h5><b>1.9 PROFESSIONAL DEVELOPMENT PROGRAM FOR THE PAST 3 YEARS</b></h5>  
        <?php
        if ($biodata->jawatan->job_category == 1) {
            $komp = $biodata->kompetensiAcademic;
        } else {
            $komp = $biodata->kompetensiAdmin;
        }
        foreach ($komp as $kompetensi) {
            if ($biodata->idpKehadiran) {
                ?>
                <div class="table-responsive"> 
                    <table class="table table-bordered" style="width:100%;"> 
                        <thead> 
                            <tr class="info">
                                <th class="text-center" style="width: 10%;">No.</th>  
                                <th class="text-center" style="width: 15%;">Date</th>  
                                <th><?= $kompetensi->kategori_nama_bi; ?> (2020 - 2022)</th>   
                            </tr>
                        </thead>

                        <?php
                        $bil1 = 1;
                        $arr = array();
                        $date = date('Y');
                        $date2 = date('Y') - 2;

                        foreach ($biodata->idpKehadiran as $l) {
                            if ($l->kategoriKursusID == $kompetensi->kategori_id) {
                                if (date("Y", strtotime($l->tarikhMasa)) >= $date2 && date("Y", strtotime($l->tarikhMasa)) <= $date) {
                                    ?>
                                    <tr>
                                        <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>

                                        <td class="text-center"><?= $l->tarikhMasa ? date("Y-m-d", strtotime($l->tarikhMasa)) : ' '; ?></td>

                                        <td><?= $l->slotID ? ucwords(strtolower($l->sasaran9->sasaran4->sasaran3->tajukLatihan)) : ' '; ?></td>

                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php
            }
        }
        ?>    

        <div style="break-after:page"></div>

        <h5><b>1.10 PLACEMENT HISTORY</b></h5> 
        <?php
        $penempatan = $biodata->allPenempatan;

        if ($penempatan) {
            ?>
            <div class="table-responsive"> 
                <table class="table table-bordered" style="width:100%;"> 
                    <thead>
                        <tr class="info">
                            <th style="width: 15%;">Date</th> 
                            <th>JFPIB</th>
                            <th>Campus</th>
                            <th>Remark</th> 
                        </tr>
                    </thead>
                    <?php
                    foreach ($penempatan as $penempatan) {
                        ?>

                        <tr>
                            <td><?= $penempatan->tarikhMula ? $penempatan->tarikhMula : '' ?></td> 
                            <td><?= $penempatan->department ? $penempatan->department->fullname : '' ?></td>
                            <td><?= $penempatan->kampus ? $penempatan->kampus->campus_name : '' ?></td>
                            <td><?= $penempatan->remark ? $penempatan->remark : '' ?></td> 

                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
        } else {
            echo "- No information";
        }
        ?>
        <div style="break-after:page"></div>

        <h5><b>1.11 APPOINTMENT POSITION</b></h5> 
        <?php if ($biodata->allSandangan) { ?>
            <div class="table-responsive"> 
                <table class="table table-sm table-bordered jambo_table table-striped"> 

                    <?php
                    $bil1 = 1;
                    ?>
                    <thead>
                        <tr class="info">
                            <th class="text-center" style="width: 30%;">Position</th> 
                            <th class="text-center">Appointment Status</th>
                            <th class="text-center">Appointment Type</th>
                            <th class="text-center" style="width: 15%;">Start Position</th> 
                        </tr>
                    </thead>
                    <?php foreach ($biodata->allSandangan as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $l->gredjawatan ? $l->gredJawatan->fname : ''; ?></td> 
                            <td class="text-center"><?= $l->sandangan_id ? $l->statusSandangan->sandangan_name : ''; ?></td>
                            <td class="text-center"><?= $l->ApmtTypeCd ? $l->jenisLantikan->ApmtTypeNm : ''; ?></td>
                            <td class="text-center"><?= $l->start_date ? $l->tarikhMulaSandangan : ''; ?></td> 
                        </tr>

                        <?php
                    }
                    ?>
                </table> 
            </div>
            <?php
        } else {
            echo "- No information";
        }
        ?>
        <div style="break-after:page"></div>

        <h5><b>1.12 MEMBERSHIP (VERIFIED)</b></h5> 
        <?php
        if ($biodata->badanprofesionalVerified) {
            $badanprofesional = $biodata->badanprofesionalVerified;
            ?>
            <div class="table-responsive">

                <table class="table table-sm table-bordered jambo_table table-striped">  
                    <thead>
                        <tr class="info">
                            <th>Name </th>
                            <th>Level</th>
                            <th>No. Membership</th>
                            <th>Position</th>
                            <th>Date</th>
                            <th>Fee</th>
                            <th>Verified</th> 
                        </tr>  
                    </thead>
                    <?php
                    if ($badanprofesional) {

                        foreach ($badanprofesional as $badanprofesionalkakitangan) {
                            ?>

                            <tr>
                                <td><?= $badanprofesionalkakitangan->nambadanprofesional ?></td>
                                <td><?= $badanprofesionalkakitangan->peringkat ? $badanprofesionalkakitangan->peringkat->LvlNm : '-' ?></td>
                                <td><?= $badanprofesionalkakitangan->membership_no ? $badanprofesionalkakitangan->membership_no : '-' ?></td>
                                <td><?= $badanprofesionalkakitangan->jaw ?></td>
                                <td><?= $badanprofesionalkakitangan->tarikhmula ?> <?= $badanprofesionalkakitangan->ResignDt ? ' - ' . $badanprofesionalkakitangan->tarikhakhir : ''; ?></td>
                                <td><?= $badanprofesionalkakitangan->yuran ?></td> 
                                <td><?= $badanprofesionalkakitangan->isVerified ? 'Yes' : 'No'; ?></td>       
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
            <?php
        } else {
            echo "- No information";
        }
        ?>

        <div style="break-after:page"></div>

        <h5><b>1.13 CLINICAL CERTIFICATE (VERIFIED)</b></h5> 
        <?php
        if ($biodata->medicalCertificateVerified) {
            $cert = $biodata->medicalCertificateVerified;
            ?>
            <div class="table-responsive"> 
                <table class = "table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="info">
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date Awarded</th>
                            <th>Certificate No.</th>
                            <th>Date</th> 
                            <th>Awarded By</th> 
                        </tr>
                    </thead>
                    <?php
                    foreach ($cert as $cert) {
                        ?>
                        <tr>
                            <td><?= $cert->title ?></td>
                            <td><?= $cert->certType ? $cert->certType->certType : '-'; ?></td>
                            <td><?= $cert->dateAwd ?></td>
                            <td><?= $cert->certNo ?></td>
                            <td><?= $cert->fullDate ?></td> 
                            <td><?= $cert->awardBy ?></td> 
                        </tr>

                    <?php } ?> 
                </table> 
            </div>
            <?php
        } else {
            echo "- No information";
        }
        ?>
        <div style="break-after:page"></div>
        <?php if ($biodata->jawatan->job_category == 1) { ?>

            <h5><b>2.1 TEACHING</b></h5> 
            <?php
//        $data = array($biodata->pengajaranAsasiSains, $biodata->pengajaranCertificatePep, $biodata->pengajaranDipKejururawatan, $biodata->pengajaranDipMChina
//            , $biodata->pengajaranDipUmum, $biodata->pengajaranPascasiswazah, $biodata->pengajaranPraMChina, $biodata->pengajaranPrasiswazahPlums
//            , $biodata->pengajaranPrasiswazahPerubatan, $biodata->pengajaranPrasiswazahPpg, $biodata->pengajaranPrasiswazahUmum, $biodata->pengajaranNull);
//        if ($data) {
//            for ($i = 0; $i < count($data); $i++) {
//                $pengajaran = $data[$i];
            $pengajaran = $biodata->pengajaranbyKategori;
            if ($pengajaran) {
                ?> 
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%;">
                        <thead> 
                            <tr class="info">   
                                <th>No.</th>  
                                <th>Category</th> 
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Hour</th> 
                                <th>Section</th>  
                                <th>No. Of Students</th>
                                <th>Academic Session</th>   
                            </tr>
                        </thead>
                        <?php
                        $counter = 0;
                        foreach ($pengajaran as $pengajaran) {
                            $counter = $counter + 1;
                            ?> 

                            <tr>
                                <td><?= $counter; ?></td>
                                <td> <?= $pengajaran->KATEGORIPELAJAR ? $pengajaran->KATEGORIPELAJAR : ' '; ?> </td>
                                <td> <?= $pengajaran->SMP07_KodMP ? $pengajaran->SMP07_KodMP : ' '; ?> </td> 
                                <td> <?= $pengajaran->NAMAKURSUS ? $pengajaran->NAMAKURSUS : ' '; ?> </td> 
                                <td class="text-center"> <?= $pengajaran->JAMKREDIT ? $pengajaran->JAMKREDIT : ' '; ?> </td>  
                                <td class="text-center"> <?= $pengajaran->SEKSYEN ? $pengajaran->SEKSYEN : ' '; ?> </td> 
                                <td class="text-center"> <?= $pengajaran->BILPELAJAR ? $pengajaran->BILPELAJAR : ' '; ?> </td>
                                <td> <?= $pengajaran->SESI ? $pengajaran->SESI : ' '; ?> </td> 
                            </tr>

                        <?php }
                        ?>

                    </table>
                </div>  
                <?php
//                }
//            }
            } else {
                echo "- No information";
            }
            ?>  
            <br/> 
            <div style="break-after:page"></div>
            <h5><b>2.2 BLENDED LEARNING</b></h5> 
            <?php
            $blended = $biodata->blendedLearningSmartv3;
            if ($blended) {

                if ($blended == 'no_ad_ums') {
                    ?>
                    <span style="color: red;">BLENDED LEARNING = EMAIL UMS NOT UPDATED !</span>
                    <?php
                } else {
                    ?>

                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%;">
                            <thead> 
                                <tr class="info">        
                                    <th>No.</th>  
                                    <th>Course Code & Course Title</th>
                                    <th>Status</th>  
                                </tr> 
                            </thead>

                            <?php
                            $counter = 0;
                            foreach ($blended as $blended) {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td>  
                                    <td> <?= $blended->fullname ? $blended->fullname : ' '; ?> </td> 
                                    <td> <?= $blended->status ? $blended->status : ' '; ?> </td>   
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                }
            } else {
//        echo 'No data - (SUMBER + elnpt.tbl_blended_learning)';
                echo "- No information";
            }
            ?>
            <br/>
            <div style="break-after:page"></div>

            <h5><b>3.1 RESEARCH (COMPLETED & ONGOING)</b></h5>
            <?php
            $research = $biodata->research2;
            if ($research) {
                ?>  
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">     
                        <thead> 
                            <tr class="info"> 
                                <th>No.</th>   
                                <th>Title</th> 
                                <th>Head-researchers <br/>(CO-researchers)</th> 
                                <th>Role</th>
                                <th>Date</th>  
                                <th>Source of Funds (Agency Name)</th>  
                            </tr>  
                        </thead>
                        <?php
                        $counter = 0;
                        foreach ($research as $research) {
                            if ($research->ResearchStatus == 'Selesai' || $research->ResearchStatus == 'Sedang Berjalan') {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td>  
                                    <td><?= $research->Title ? $research->Title : '-'; ?></td> 
                                    <td><?= $research->Researchers ? ucwords(strtolower($research->Researchers)) : '-'; ?></td> 
                                    <td><?= $research->Membership ? $research->Membership : '-'; ?></td>
                                    <td><?= $research->StartDate ? $research->StartDate : ' '; ?> - <?= $research->EndDate ? $research->EndDate : ' '; ?></td>
                                    <td><?= $research->AgencyName ? $research->AgencyName : ' '; ?> <?= $research->Amount ? '(RM' . sprintf('%0.2f', $research->Amount) . ')' : ' '; ?></td> 

                                </tr> 
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <br/> 
                <?php
            } else {
                echo "- No information";
            }
            ?>
            <br/> 
            <div style="break-after:page"></div>

            <h5><b>4.1 SUPERVISION (UMS)</b></h5>
            <?php
            $penyeliaan = $biodata->penyeliaanPHD;

            if ($penyeliaan) {
                ?>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr>
                            <th colspan="6">Level : PHD</th>  
                        </tr>
                        <thead> 
                            <tr class="info">
                                <th>No.</th> 
                              <th width="30%">Student Name</th>   
                                <th width="12%">Faculty</th>      
                                <th width="20%">Role</th>   
                                <th width="15%">Status</th>     
                                 <th width="15%">Method Study</th>  
                            </tr> 
                        </thead>
                        <?php
                        $counter = 0;
                        foreach ($penyeliaan as $penyeliaan) {

                            $counter = $counter + 1;
                            ?>  

                            <tr>   
                                <th><?= $counter; ?>.</th> 
                                <td><?= $penyeliaan->SMP01_Nama ? $penyeliaan->SMP01_Nama : ' '; ?></td> 
                                <td><?= $penyeliaan->SMP01_Fakulti ? $penyeliaan->SMP01_Fakulti : ' '; ?></td>   
                                <td><?= $penyeliaan->NamaBI ? $penyeliaan->NamaBI : ' '; ?></td> 
                                <td><?= $penyeliaan->StatusBI ? $penyeliaan->StatusBI : ' '; ?></td>  
                                <td><?= $penyeliaan->MethodStudyName ? $penyeliaan->MethodStudyName : ' '; ?></td> 
                            </tr> 

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
            }
            ?> 

            <?php
            $penyeliaanM = $biodata->penyeliaanMASTER;

            if ($penyeliaanM) {
                ?>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr>
                            <th colspan="6">Level : MASTER</th>  
                        </tr>
                        <thead> 
                            <tr class="info">
                                <th>No.</th> 
                                <th width="30%">Student Name</th>   
                                <th width="12%">Faculty</th>      
                                <th width="20%">Role</th>   
                                <th width="15%">Status</th>     
                                 <th width="15%">Method Study</th>    
                            </tr> 
                        </thead> 
                        <?php
                        $counter = 0;
                        foreach ($penyeliaanM as $penyeliaan) {

                            $counter = $counter + 1;
                            ?>  

                            <tr>   
                                <th><?= $counter; ?>.</th> 
                                <td><?= $penyeliaan->SMP01_Nama ? $penyeliaan->SMP01_Nama : ' '; ?></td>  
                                <td><?= $penyeliaan->SMP01_Fakulti ? $penyeliaan->SMP01_Fakulti : ' '; ?></td>   
                                <td><?= $penyeliaan->NamaBI ? $penyeliaan->NamaBI : ' '; ?></td> 
                                <td><?= $penyeliaan->StatusBI ? $penyeliaan->StatusBI : ' '; ?></td>  
                                <td><?= $penyeliaan->MethodStudyName ? $penyeliaan->MethodStudyName : ' '; ?></td> 
                            </tr> 

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
            }
            ?> 

             
            <br/> 
            <div style="break-after:page"></div>

            <h5><b>4.2 SUPERVISION (EXTERNAL)</b></h5>

            <?php
            $penyeliaanLPHD = $biodata->penyeliaan2PHDLuar;

            if ($penyeliaanLPHD) {
                ?> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr>
                            <th colspan="8">Level : PHD</th>  
                        </tr>
                        <thead> 
                            <tr class="info">
                                <th style="width: 2%;">No.</th> 
                                <th>Student Name</th>  
                                <th>No Matric</th>  
                                <th>Institute Name</th>   
                                <th>Role</th> 
                                <th style="width: 10%;">Date</th> 
                            </tr> 
                        </thead>
                        <?php
                        $counter = 0;
                        foreach ($penyeliaanLPHD as $penyeliaan) {

                            $counter = $counter + 1;
                            ?>  

                            <tr>   
                                <th><?= $counter; ?>.</th> 
                                <td><?= $penyeliaan->NamaPelajar ? $penyeliaan->NamaPelajar : ' '; ?></td>
                                <td><?= $penyeliaan->Nomatrik ? $penyeliaan->Nomatrik : ' '; ?> </td>  
                                <td><?= $penyeliaan->NamaInstitut ? $penyeliaan->NamaInstitut : ' '; ?></td>   
                                <td><?= $penyeliaan->TahapPenyeliaan ? $penyeliaan->TahapPenyeliaan : ' '; ?></td>
                                <td><?= $penyeliaan->TahunKonvokesyen ? $penyeliaan->TahunKonvokesyen : ' '; ?></td> 


                            </tr> 

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
            }
            ?> 

            <?php
            $penyeliaanLM = $biodata->penyeliaan2MASTERLuar;

            if ($penyeliaanLM) {
                ?> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <tr>
                            <th colspan="8">Level : MASTER</th>  
                        </tr>
                        <thead> 
                            <tr class="info">
                                <th style="width: 2%;">No.</th> 
                                <th>Student Name</th>  
                                <th>No Matric</th>  
                                <th>Institute Name</th>   
                                <th>Role</th> 
                                <th style="width: 10%;">Date</th> 
                            </tr> 
                        </thead>
                        <?php
                        $counter = 0;
                        foreach ($penyeliaanLM as $penyeliaan) {

                            $counter = $counter + 1;
                            ?>  

                            <tr>   
                                <th><?= $counter; ?>.</th> 
                                <td><?= $penyeliaan->NamaPelajar ? $penyeliaan->NamaPelajar : ' '; ?></td>
                                <td><?= $penyeliaan->Nomatrik ? $penyeliaan->Nomatrik : ' '; ?> </td>  
                                <td><?= $penyeliaan->NamaInstitut ? $penyeliaan->NamaInstitut : ' '; ?></td>   
                                <td><?= $penyeliaan->TahapPenyeliaan ? $penyeliaan->TahapPenyeliaan : ' '; ?></td>
                                <td><?= $penyeliaan->TahunKonvokesyen ? $penyeliaan->TahunKonvokesyen : ' '; ?></td> 


                            </tr> 

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
//            echo 'No data (PHP) - (SUMBER + dbo.Ext_HR02_Penyeliaan)';
            }
            ?>  

            <br/> 
            <div style="break-after:page"></div> 

            <h5><b>5.1 PUBLICATION (VERIFIED)</b></h5>
            <?php
            $publicationC = $biodata->publication;
            if ($publicationC) {
                ?> 

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%">  

                        <?php
                        $type = $biodata->PublicationSort();
                        foreach ($type as $type) {
                            $typeN = $type->name;
                            ?>  
                            <tr>  
                                <th colspan="6"><?= $typeN; ?> </th>
                            </tr>
                            <thead> 
                                <tr class="info">  
                                    <th>No.</th> 
                                    <th width="39%"><?= $typeN; ?> Detail</th>  
                                    <th width="16%">Role</th> 
                                    <th width="10%">Year</th>
                                    <th width="15%">Status Indeks</th> 
                                    <th width="13%">Status</th>

                                </tr> 
                            </thead> 
                            <?php
                            $publication = $biodata->publication;
                            $counter = 1;
                            foreach ($publication as $publication) {
                                $check = $publication->Keterangan_PublicationTypeID ? $publication->Keterangan_PublicationTypeID : '';
                                if ($check == $type->name) {
                                    ?> 

                                    <tr> 
                                        <td><?= $counter; ?></td> 
                                        <td>
                                            <?= $publication->FullAuthorName ? $publication->FullAuthorName . '.' : ''; ?>
                                            <?= $publication->PublicationYear ? $publication->PublicationYear : '.'; ?>
                                            <?= $publication->ProsidingName ? $publication->ProsidingName . '.' : ''; ?>
                                            <?= $publication->Title ? $publication->Title . '.' : ''; ?> 
                                            <?= $publication->Publisher ? $publication->Publisher . '.' : ''; ?> 
                                            <?= $publication->SourceName ? $publication->SourceName . '.' : ''; ?> 
                                            <?= $publication->Volume ? 'Jil. ' . $publication->Volume . '.' : ''; ?> 
                                            <?= $publication->Issue ? $publication->Issue . '.' : ''; ?> 
                                            <?= $publication->PageNumber ? $publication->PageNumber . '.' : ''; ?> 
                                        </td> 
                                        <td><?= $publication->KeteranganBI_WriterStatus ? $publication->KeteranganBI_WriterStatus : ''; ?></td>
                                        <td><?= $publication->PublicationYear ? $publication->PublicationYear : ''; ?></td>
                                        <td><?= $publication->IndexingDesc ? $publication->IndexingDesc : ''; ?></td>
                                        <td><?= $publication->Keterangan_PublicationStatus ? $publication->Keterangan_PublicationStatus : ''; ?></td>
                                    </tr> 
                                    <?php
                                    $counter = $counter + 1;
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
                <?php
            } else {
//            echo '<br/> No data - (dbo.vw_LNPT_PublicationV2) /db 10';
            }
            ?>
            <br/>
            <div style="break-after:page"></div>

            <h5><b>6.1 CONFERENCES</b></h5>
            <?php
            $dataPersidangan = array($biodata->persidanganAhliPanel, $biodata->persidanganKetuaSesi, $biodata->persidanganKeynoteSpeaker, $biodata->persidanganPembentang
                , $biodata->persidanganPembentangJemputan, $biodata->persidanganPembentangPoster, $biodata->persidanganPengerusi
                , $biodata->persidanganPeserta, $biodata->persidanganTiadaData);
            for ($i = 0; $i < count($dataPersidangan); $i++) {

                $persidangan = $dataPersidangan[$i];
                if ($persidangan) {
                    ?>

                    <div class="table-responsive">
                        <table class="table table-bordered" style="width:100%;"> 
                            <thead> 
                                <tr class="info"> 
                                    <th>No.</th>  
                                    <th style="width: 15%;">Role</th>  
                                    <th style="width: 20%;">Article's Title</th>
                                    <th>Conference/Seminar Title</th>  
                                    <th style="width: 15%;">Date</th>
                                    <th style="width: 15%;">Level</th>
                                    <th style="width: 15%;">Venue</th> 
                                </tr> 
                            </thead>
                            <?php
                            $counter = 0;
                            foreach ($persidangan as $persidangan) {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td>  
                                    <td><?= $persidangan->Peranan ? ucwords(strtolower($persidangan->Peranan)) : ' '; ?></td> 
                                    <td><?= $persidangan->TajukKertas ? ucwords(strtolower($persidangan->TajukKertas)) : ' '; ?> </td>  
                                    <td><?= $persidangan->TajukPersidangan ? ucwords(strtolower($persidangan->TajukPersidangan)) : ' '; ?></td> 
                                    <td><?= $persidangan->Mula ? $persidangan->Mula : ''; ?> - <?= $persidangan->Tamat ? $persidangan->Tamat : ''; ?></td>
                                    <td><?= $persidangan->Peringkat ? ucwords(strtolower($persidangan->Peringkat)) : ' '; ?></td> 
                                    <td><?= $persidangan->Tempat ? ucwords(strtolower($persidangan->Tempat)) : ' '; ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <br/>
                    <?php
                } else {
//                echo '<br/> No data - (SUMBER + dbo.vw_Conference)';
                }
            }
            ?> 
            <br/>
            <div style="break-after:page"></div>
            <h5><b>6.2 DESIGNER COMPETITION</b></h5>
            <?php
            $dataPEREKA = array($biodata->pertandinganPerekaKetua, $biodata->pertandinganPerekaAhli);
            if ($dataPEREKA) {
                for ($i = 0; $i < count($dataPEREKA); $i++) {
                    $pereka = $dataPEREKA[$i];
                    if ($pereka) {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%;"> 
                                <thead> 
                                    <tr class="info">  
                                        <th style="width: 5%;">No.</th>  
                                        <th style="width: 10%;">Role</th> 
                                        <th style="width: 10%;">Year</th>
                                        <th style="width: 50%;">Title</th>
                                        <th>Level</th>   
                                    </tr> 
                                </thead> 
                                <?php
                                $counter = 0;
                                foreach ($pereka as $pereka) {
                                    $counter = $counter + 1;
                                    ?>  
                                    <tr>
                                        <td><?= $counter; ?></td>  
                                        <td><?= $pereka->Peranan ? $pereka->Peranan : ' '; ?></td> 
                                        <td><?= $pereka->Tahun ? $pereka->Tahun : ' '; ?></td> 
                                        <td><?= $pereka->KodPereka ? $pereka->KodPereka : ' '; ?></td> 
                                        <td><?= $pereka->Tahap ? $pereka->Tahap : ' '; ?></td> 
                                    </tr> 
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <br/>
                        <?php
                    } else {
//            echo '<br/> No data - (SUMBER + dbo.vw_LNPT_PertandinganPereka)<br/>';
                    }
                }
            } else {
                echo "- No information";
            }
            ?>

            <br/>
            <div style="break-after:page"></div>
            <h5><b>6.3 INNOVATION </b></h5>

            <?php
            $dataINOVASI = array($biodata->inovasiLeader, $biodata->inovasiMember, $biodata->inovasiPresenter, $biodata->inovasiProfessionalService);
            if ($dataINOVASI) {
                for ($i = 0; $i < count($dataINOVASI); $i++) {

                    $inovasi = $dataINOVASI[$i];
                    if ($inovasi) {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%;"> 
                                <thead> 
                                    <tr class="info">   
                                        <th>No.</th>  
                                        <th style="width: 10%;">Membership</th>
                                        <th style="width: 10%;">Role</th>  
                                        <th style="width: 40%;">Title</th> 
                                        <th style="width: 15%;">Date</th> 
                                        <th>Organisasi</th> 
                                        <th style="width: 10%;">Status</th> 
                                    </tr> 
                                </thead>
                                <?php
                                $counter = 0;
                                foreach ($inovasi as $inovasi) {
                                    $counter = $counter + 1;
                                    ?> 

                                    <tr>
                                        <td><?= $counter; ?></td>  
                                        <td><?= $inovasi->Keahlian ? $inovasi->Keahlian : ' '; ?></td>
                                        <td><?= $inovasi->Peranan ? $inovasi->Peranan : ' '; ?></td>  
                                        <td><?= $inovasi->Tajuk ? $inovasi->Tajuk : ' '; ?></td>
                                        <td><?= $inovasi->TarikhMula ? Yii::$app->formatter->asDate($inovasi->TarikhMula, 'yyyy-MM-dd') : ' '; ?> - <?= $inovasi->TarikhAkhit ? Yii::$app->formatter->asDate($inovasi->TarikhAkhit, 'yyyy-MM-dd') : ' '; ?></td>
                                        <td><?= $inovasi->Organisasi ? $inovasi->Organisasi : ' '; ?></td>  
                                        <td><?= $inovasi->Status ? $inovasi->Status : ' '; ?></td>
                                    </tr>



                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <br/>
                        <?php
                    } else {
//            echo '<br/> No data - (SUMBER + dbo.Ext_PPI11_Inovasi)';
                    }
                }
            } else {
                echo "- No information";
            }
            ?>

            <br/>
            <div style="break-after:page"></div>


            <h5><b>6.4 TECHNOLOGY INNOVATION </b></h5> 
            <?php
            $inovasi2 = $biodata->teknologiInvasi;
            if ($inovasi2) {
                $level = $biodata->teknologiInvasiLevel;
                foreach ($level as $level) {
                    $levelN = $level->tahap_penyertaan;
                    ?> 
                    <div class="table-responsive"> 
                        <table class="table table-sm table-bordered jambo_table table-striped">  
                            <thead> 
                                <tr class="info">   
                                    <th>Level</th> 
                                    <th colspan="4"><?= $levelN; ?></th>  
                                </tr>
                                <tr> 
                                    <th>No.</th>    
                                    <th style="width: 10%;">Role</th>  
                                    <th style="width: 50%;">Title</th>  
                                    <th>Category</th> 
                                    <th style="width: 15%;">Amount</th> 
                                </tr> 
                            </thead>
                            <?php
                            $counter = 0;
                            foreach ($inovasi2 as $inovasi) {
                                $check = $inovasi->tahap_penyertaan ? $inovasi->tahap_penyertaan : ' ';
                                if ($check == $levelN) {
                                    $counter = $counter + 1;
                                    ?> 

                                    <tr>
                                        <td><?= $counter; ?></td>   
                                        <td><?= $inovasi->peranan ? $inovasi->peranan : ' '; ?></td> 
                                        <td><?= $inovasi->nama_projek ? $inovasi->nama_projek : ' '; ?></td> 
                                        <td><?= $inovasi->kategori ? $inovasi->kategori : ' '; ?></td>  
                                        <td><?= $inovasi->amaun ? '(RM' . sprintf('%0.2f', $inovasi->amaun) . ')' : ' '; ?></td>
                                    </tr>



                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <br/>
                    <?php
                }
            }
            ?>
            <br/> 
            <div style="break-after:page"></div>

            <h5><b>7.1 CONSULTANCY (VERIFIED)</b></h5>

            <?php
            $dataOutreaching = array($biodata->outreachingInternationalSelesai, $biodata->outreachingNationalSelesai, $biodata->outreachingUniversitySelesai, $biodata->outreachingNoDataSelesai);
            $empty = '';
            if ($dataOutreaching) {
                for ($i = 0; $i < count($dataOutreaching); $i++) {

                    $outreaching = $dataOutreaching[$i];
                    if ($outreaching) {
                        ?>

                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%;"> 
                                <thead> 
                                    <tr class="info">   
                                        <th>No.</th>
                                        <th style="width: 15%;">Level</th> 
                                        <th>Title</th> 
                                        <th>Roles Project</th>
                                        <th>Category</th>  
                                        <th style="width: 15%;">Date</th> 
                                        <th style="width: 15%;">Source (Amount)</th>  
                                    </tr> 
                                </thead> 
                                <?php
                                $counter = 0;
                                foreach ($outreaching as $outreaching) {
                                    $counter = $counter + 1;
                                    ?> 

                                    <tr>
                                        <td><?= $counter; ?></td>
                                        <td><?= $outreaching->Peringkat ? $outreaching->Peringkat : ' '; ?></td>
                                        <td><?= $outreaching->Tajuk ? $outreaching->Tajuk : ''; ?></td> 
                                        <td><?= $outreaching->Peranan ? $outreaching->Peranan : ''; ?></td> 
                                        <td><?= $outreaching->ConsultationType ? $outreaching->ConsultationType : ''; ?></td>
                                        <td><?= $outreaching->TarikhMula ? $outreaching->TarikhMula : ' '; ?> <?= $outreaching->TarikhAkhit ? $outreaching->TarikhAkhit : ' '; ?></td>
                                        <td><?= $outreaching->Jumlah ? '(RM' . sprintf('%0.2f', $outreaching->Jumlah) . ')' : ' '; ?></td>
                                    </tr> 
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <br/> 
                        <?php
                    } else {
                        $empty = true;
                    }
                }
            }
            if ($empty == true) {
                echo "- No information";
            }
            ?>  


            <br/> 
            <div style="break-after:page"></div>
            <h5><b>7.2 CONSULTANCY CLINICAL (VERIFIED)</b></h5>
            <?php
            $outreaching = $biodata->outreachingClinical;
            if ($outreaching) {
                ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">  
                        <thead>
                        <tr class="info">   
                            <th>No.</th>
                            <th style="width: 15%;">Type</th> 
                            <th>Title</th> 
                            <th style="width: 10%;">Status</th> 
                            <th style="width: 10%;">Date</th>   
                            <th style="width: 15%;">Time (Start-End)</th>  
                            <th style="width: 10%;">Hour</th>   
                        </tr>  
                        </thead>
                        <?php
                        $counter = 0;
                        $totalHour = 0;
                        foreach ($outreaching as $outreaching) {
                            if ($outreaching->ApproveStatus == 'V') {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td>
                                    <td><?= $outreaching->JenisRawatan ? $outreaching->JenisRawatan : ' '; ?></td>
                                    <td><?= $outreaching->Rawatan ? $outreaching->Rawatan : ''; ?></td> 
                                    <td><?= $outreaching->Status ? $outreaching->Status : ''; ?></td>  
                                    <td><?= $outreaching->TarikhMula ? $outreaching->TarikhMula : ' '; ?></td> 
                                    <td><?= $outreaching->JamMula ? Yii::$app->formatter->asTime($outreaching->JamMula) : ' '; ?> <?= $outreaching->JamTamat ? ' - ' . Yii::$app->formatter->asTime($outreaching->JamTamat) : ' '; ?></td> 
                                    <td class="text-center">
                                        <?php
                                        $hour = $outreaching->JumlahJam ? $outreaching->JumlahJam : 0;
                                        echo $hour;
                                        $totalHour = $totalHour + $hour;
                                        ?> 
                                    </td>
                                </tr> 
                                <?php
                            }
                        }
                        ?>  
                        <tr>
                            <th colspan="6" class="text-right">Total Hour</th>
                            <th class="text-center"><?= $totalHour; ?></th> 
                        </tr>
                    </table>
                </div>
                <?php
            } else {
                echo '- No Information';
            }
            ?>

            <div style="break-after:page"></div>
            <h5><b>8.0 SERVICES TO THE UNIVERSITY</b></h5>
            <?php
            $swUni = $biodata->usercv ? $biodata->usercv->swUniversity : '';
            if ($swUni) {
                ?>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <thead> 
                            <tr class="info">   
                                <th>No.</th> 
                                <th style="width: 30%;">Service</th> 
                                <th style="width: 15%;">Year</th>
                                <th style="width: 15%;">Role</th>  
                                <th>Role Details</th>
                                <th>Category</th>    

                            </tr> 
                        </thead>

                        <?php
                        if ($biodata->serviceUniversity) {
                            $counter = 0;
                            foreach ($biodata->serviceUniversity as $university) {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td> 
                                    <td><?= $university->service ? $university->service : ' '; ?> </td> 
                                    <td><?= $university->year ? $university->year : ' '; ?> </td> 
                                    <td><?= $university->role_key ? $university->role_key : ' '; ?> </td> 
                                    <td><?= $university->role ? $university->role : ' '; ?> </td> 
                                    <td><?= $university->lvl ? $university->lvl->output : ' '; ?></td>    
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">No Information</td>  
                            </tr>

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
                echo "- No information";
            }
            ?>

            <div style="break-after:page"></div>
            <h5><b>8.1 COMMUNITY SERVICES</b></h5>
            <?php
            $swCom = $biodata->usercv ? $biodata->usercv->swCommunity : '';
            if ($swCom) {
                ?>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <thead> 
                            <tr class="info">   
                                <th style="width: 7%;">No.</th> 
                                <th style="width: 40%;">Service</th>
                                <th style="width: 15%;">Year</th>
                                <th style="width: 15%;">Role</th>  
                                <th>Role Details</th> 
                                <th>Level</th>    

                            </tr> 
                        </thead>

                        <?php
                        if ($biodata->serviceCommunity) {
                            $counter1 = 0;
                            foreach ($biodata->serviceCommunity as $community) {
                                $counter1 = $counter1 + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter1; ?></td> 
                                    <td><?= $community->service ? $community->service : ' '; ?> </td> 
                                    <td><?= $community->year ? $community->year : ' '; ?> </td> 
                                    <td><?= $community->role_key ? $community->role_key : ' '; ?> </td> 
                                    <td><?= $community->role ? $community->role : ' '; ?> </td> 
                                    <td><?= $community->lvl ? $community->lvl->output : ' '; ?></td>    
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">No Information</td>  
                            </tr>

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <br/>
                <?php
            } else {
                echo "- No information";
            }
            ?>
            <div style="break-after:page"></div>
            <h5><b>9.0 ESTEEM & LEADERSHIP</b></h5>
            <?php if ($biodata->esteem) { ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <thead> 
                            <tr class="info"> 
                                <th>No.</th> 
                                <th>Type</th>
                                <th style="width: 40%;">Title</th>
                                <th>Year</th>   

                            </tr> 
                        </thead>

                        <?php
                        $counter = 0;
                        foreach ($biodata->esteem as $esteem) {
                            $counter = $counter + 1;
                            ?> 

                            <tr>
                                <td><?= $counter; ?></td> 
                                <td><?= $esteem->type ? $esteem->name->output : ' '; ?> </td> 
                                <td><?= $esteem->title ? $esteem->title : ' '; ?> </td> 
                                <td><?= $esteem->year ? $esteem->year : ' '; ?> </td>     
                            </tr>

                            <?php
                        }
                        ?>
                    </table>
                </div>

                <?php
            } else {
                echo "- No information";
            }
            ?>
            <div style="break-after:page"></div>
            <h5><b>9.1 THESIS EXAMINER</b></h5>
            <?php if ($biodata->examiner) { ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <thead> 
                            <tr class="info">  
                                <th>No.</th>  
                                <th style="width: 30%;">Title</th>
                                <th>Year</th>  
                                <th>Examiner Type</th> 
                                <th>Level</th> 
                                <th style="width: 15%;">Student Name</th> 
                                <th style="width: 16%;">Institutions</th>  

                            </tr> 
                        </thead>
                        <?php
                        $counter2 = 0;
                        foreach ($biodata->examiner as $examiner) {
                            $counter2 = $counter2 + 1;
                            ?> 

                            <tr>
                                <td><?= $counter2; ?></td>  
                                <td><?= $examiner->title ? $examiner->title : ' '; ?> </td> 
                                <td><?= $examiner->year ? $examiner->year : ' '; ?> </td>   
                                <td><?= $examiner->examiner_type ? ucwords($examiner->examiner_type) : ' '; ?> </td> 
                                <td><?= $examiner->level ? ucwords($examiner->level) : ' '; ?> </td> 
                                <td><?= $examiner->student_name ? $examiner->student_name : ' '; ?> </td> 
                                <td><?= $examiner->institution ? $examiner->university->output : ' '; ?> </td>   
                            </tr>

                            <?php
                        }
                        ?>
                    </table>
                </div>
                <?php
            } else {
                echo "- No information";
            }
            ?>
        <?php } ?>
    </body>
</html>