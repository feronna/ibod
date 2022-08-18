<?php

use yii\helpers\Html;
use app\models\kehadiran\TblWarnaKad;
use yii\helpers\VarDumper;

error_reporting(0);
?>
 <p align="right">  <?= Html::a('Back', ['data/search'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
<?php echo $this->render('main', ['biodata' => $biodata]); ?> 

<div class="x_panel">
    <br />

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <?php if ($biodata->jawatan->job_category == 2) { ?>
                <p align="right"><?= Html::a('<i class="fa fa-download" aria-hidden="true"></i>', ['download-profil', 'id' => ($biodata->ICNO)], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']); ?></p>
            <?php } else { ?>
                <br />
            <?php } ?>

            <div class="table-responsive">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="6">ACTUAL POST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="width:16%">Grade</th>
                            <td style="width:16%"><?= $biodata->jawatan->gred; ?></td>
                            <th style="width:17%">
                                Permanent Appointment <br />
                                Period at UMS
                            </th>
                            <td style="width:17%">
                                <?php
                                if ($biodata->statLantikan == 1) { //tetap
                                    echo $biodata->servPeriodPermanentBI;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <th style="width:17%">Date Assigned</th>
                            <td style="width:17%"><?php
                                                    if ($biodata->statLantikan == 1) { //tetap
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
                                Current Positions <br />
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
                                Date appointed to <br />
                                current position
                            </th>
                            <td><?php
                                if ($biodata->statLantikan == 1) { //tetap
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
            </div>
        </div>
        <br />
    </div>
    <br />
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>Education Background</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Professional Expertise</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><b>Honour(S) & Professional Award</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><b>Recognition</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false"><b>Career History</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false"><b>Attendance Report</b></a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
                    <?php if ($biodata->akademik) { ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="list-unstyled timeline widget">
                                <?php
                                foreach ($biodata->akademik as $akademik) {
                                ?>
                                    <li>
                                        <div class="block">
                                            <div class="block-content">
                                                <h2 class="title">
                                                    <?php
                                                    echo $akademik->EduCertTitle . ', ';
                                                    if ($akademik->InstCd == 004) {
                                                        echo 'Lain-Lain';
                                                    } else {
                                                        echo $akademik->institut ? $akademik->institut->InstNm : '';
                                                    }
                                                    ?></h2>
                                                <div class="byline">
                                                    <big><span>Graduation Date: </span> <a><?= $biodata->getTarikh($akademik->ConfermentDt); ?></a> <br />
                                                        <span>Major: </span> <a><?= $akademik->major ? $akademik->major->MajorMinor : 'Tiada Maklumat'; ?></a>
                                                    </big>
                                                </div>
                                                <div class="excerpt"> <b>Grade:</b> <?= $akademik->OverallGrade ? $akademik->OverallGrade : 'Tiada Maklumat'; ?> </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <tr>
                                <th>No.</th>
                                <th style="width: 15%;">Group</th>
                                <th>Area</th>
                                <th style="width: 10%;">Date Approved</th>
                            </tr>
                            <?php
                            $kepakaran = $biodata->kepakaran;
                            if ($kepakaran) {
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
                                <tr>
                                    <td colspan="4" class="text-center"><b>Source</b>: SMPPI</td>
                                </tr>
                            <?php } else {
                            ?>
                                <tr>
                                    <td colspan="4" class="text-center">No Information</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center"><b>Source</b>: SMPPI</td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped">

                                    <?php
                                    if ($biodata->anugerah) {
                                        $bil1 = 1;
                                    ?>
                                        <tr>
                                            <th class="text-center">Award</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">From</th>
                                            <th class="text-center" style="width: 10%;">Date</th>
                                            <th class="text-center">Category</th>
                                        </tr>
                                        <?php foreach ($biodata->anugerah as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= $l->namaAnugerah ? $l->namaAnugerah->Awd : ''; ?></td>
                                                <td class="text-center"><?= $l->gelaran ? $l->gelaran->Title : ''; ?></td>
                                                <td class="text-center"><?= $l->dianugerahkanOleh ? $l->dianugerahkanOleh->CfdBy : ''; ?></td>
                                                <td class="text-center"><?= $l->AwdCfdDt ? $l->AwdCfdDt : ''; ?></td>
                                                <td class="text-center"><?= $l->kategoriAnugerah ? $l->kategoriAnugerah->AwdCat : ''; ?></td>
                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped">

                                    <?php
                                    if ($biodata->recognition) {
                                        $bil1 = 1;
                                    ?>
                                        <tr>
                                            <th class="text-center">Award</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">From</th>
                                            <th class="text-center">Level</th>
                                            <th class="text-center">Invention Title</th>
                                            <th class="text-center">Event</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Link</th>
                                            <th class="text-center">remark</th>
                                        </tr>
                                        <?php foreach ($biodata->recognition as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= $l->recogNm; ?></td>
                                                <td class="text-center"><?= $l->recogCat; ?></td>
                                                <td class="text-center"><?= $l->recogTo; ?></td>
                                                <td class="text-center"><?= $l->conferBody; ?></td>
                                                <td class="text-center"><?= $l->recogLvl; ?></td>
                                                <td class="text-center"><?= $l->inventionTitle; ?></td>
                                                <td class="text-center"><?= $l->event; ?></td>
                                                <td class="text-center"><?= $l->date; ?></td>
                                                <td class="text-center"><?= $l->link; ?></td>
                                                <td class="text-center"><?= $l->remark; ?></td>
                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                    <?php
                    $pengalaman = $biodata->pengalaman;
                    if ($pengalaman) {
                    ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped">
                                    <tr>
                                        <th>No.</th>
                                        <th>Position</th>
                                        <th>Organization Name</th>
                                        <th>Sector</th>
                                        <th>Type</th>
                                        <th>Carry Services</th>
                                        <th style="width: 10%;">Start Date</th>
                                        <th style="width: 10%;">End Date</th>
                                    </tr>
                                    <?php
                                    $counter = 0;
                                    foreach ($pengalaman as $pengalaman) {
                                        $counter = $counter + 1;
                                    ?>

                                        <tr>
                                            <td><?= $counter; ?></td>
                                            <td><?= $pengalaman->PrevEmpRemarks ? $pengalaman->PrevEmpRemarks : ''; ?></td>
                                            <td><?= $pengalaman->OrgNm ? $pengalaman->OrgNm : ''; ?></td>
                                            <td> <?= $pengalaman->OccSectorCd ? $pengalaman->sektorPekerjaan->OccSector : ''; ?> </td>
                                            <td> <?= $pengalaman->CorpBodyTypeCd ? $pengalaman->jenisBadanMajikan->CorpBodyType : ''; ?> </td>
                                            <td> <?php
                                                    if ($pengalaman->WithServices) {
                                                        if ($pengalaman->WithServices == 1) {
                                                            echo 'Ya';
                                                        } else {
                                                            echo 'Tidak';
                                                        }
                                                    } else {
                                                        echo '';
                                                    }
                                                    ?>
                                            </td>
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
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <tr>
                                <th class="text-center" rowspan="2">Year</th>
                                <th class="text-center" colspan="3">Color Card</th>
                                <th class="text-center" rowspan="2">Achievement</th>
                            </tr>
                            <tr>
                                <th class="text-center">YELLOW</th>
                                <th class="text-center">GREEN</th>
                                <th class="text-center">RED</th>
                            </tr>
                            <?php
                            for ($i = 0; $i <= 2; $i++) {
                                $tahun = date('Y') - $i;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $tahun ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'YELLOW') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'GREEN') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::totalByCardColor($tahun, $biodata->ICNO, 'RED') ?></td>
                                    <td class="text-center"><?= TblWarnaKad::prestasiWarnaKad($tahun, $biodata->ICNO) ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <br />
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanela" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1a" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>myIDP</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content6a" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Services</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2a" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>LNPT</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content3a" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Placement History</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content4a" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Administration Position</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content5a" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>Appointment Position History</b></a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanela" class="tab-pane active " id="tab_content1a" aria-labelledby="home-tab">
                      <?= $this->render('/data/profiling/view-latihan', [
                      'dataProvider' => $dataProvider]); ?>

                </div>
                <div role="tab" class="tab-pane fade " id="tab_content6a" aria-labelledby="home-tab">
                      <?= $this->render('/data/profiling/view-services', [
                      'senarai' => $senarai,'senarai1'=>$senarai1]); ?>

                </div>
                
              
                <div role="tabpanela" class="tab-pane fade" id="tab_content2a" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="data table table-striped no-margin">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Year</th>
                                    <th class="text-center">Point</th>
                                </tr>
                            </thead>
                            <?php if ($biodata->jawatan->job_category == 1) { ?>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCV(1, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCV(1, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCV(2, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCV(2, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCV(3, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCV(3, 'Markah'); ?></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(1, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(1, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(2, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(2, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(3, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(3, 'Markah'); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div role="tabpanela" class="tab-pane fade" id="tab_content3a" aria-labelledby="profile-tab">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered jambo_table table-striped">

                                <tr>
                                    <th style="width: 10%;">Date</th>
                                    <th style="width: 10%;">Date Updated</th>
                                    <th>JFPIU</th>
                                    <th>Campus</th>
                                    <th>Remark</th>
                                </tr>

                                <?php
                                $penempatan = $biodata->allPenempatan;

                                if ($penempatan) {
                                    foreach ($penempatan as $penempatan) {
                                ?>

                                        <tr>
                                            <td><?= $penempatan->tarikhMula ? $penempatan->tarikhMula : '' ?></td>
                                            <td><?= $penempatan->tarikhKemaskini ? $penempatan->tarikhKemaskini : '' ?></td>
                                            <td><?= $penempatan->department ? $penempatan->department->fullname : '' ?></td>
                                            <td><?= $penempatan->kampus ? $penempatan->kampus->campus_name : '' ?></td>
                                            <td><?= $penempatan->remark ? $penempatan->remark : '' ?></td>

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
                <div role="tabpanela" class="tab-pane fade" id="tab_content4a" aria-labelledby="profile-tab">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped">

                                    <?php
                                    if ($biodata->adminPosition) {
                                        $bil1 = 1;
                                    ?>
                                        <tr>
                                            <th class="text-center">Position</th>
                                            <th class="text-center">Status</th>
                                            <!--<th class="text-center">Description</th>-->
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Campus</th>
                                            <th class="text-center">Position Assigned</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Period</th>
                                        </tr>
                                        <?php
                                        $y = 0;
                                        $m = 0;
                                        $d = 0;
                                        foreach ($biodata->adminPosition as $l) {
                                        ?>

                                            <tr>
                                                <td class="text-center"><?= $l->adminpos ? $l->adminpos->position_name : ''; ?></td>
                                                <td class="text-center"><?= $l->jobStatus0 ? $l->jobStatus0->jobstatus_desc : ''; ?></td>
                                                <!--<td class="text-center"><?php // $l->description ? $l->description : '';        
                                                                            ?></td>-->
                                                <td class="text-center"><?= $l->dept ? $l->dept->fullname : ''; ?></td>
                                                <td class="text-center"><?= $l->campus ? $l->campus->campus_name : ''; ?> </td>
                                                <td class="text-center" style="width: 10%;"><?= $l->appoinment_date ? $l->appoinment_date : ''; ?></td>
                                                <td class="text-center" style="width: 10%;"><?= $l->start_date ? $l->start_date : ''; ?> - <?= $l->end_date ? $l->end_date : ''; ?></td>
                                                <td class="text-center" style="width: 10%;"><?= $l->tempoh ? $l->tempoh : ''; ?></td>

                                                <?php
                                                $curdays = 29;
                                                if ($l->getTempohType('%d') > 29) {
                                                    $curdays = $l->getTempohType('%d');
                                                }
                                                $y = $y + $l->getTempohType('%y');
                                                $m = $m + $l->getTempohType('%m');
                                                $d = $d + $l->getTempohType('%d');
                                                ?>
                                            </tr>

                                        <?php
                                        }
                                        $dtoadd = intdiv($d, $curdays);
                                        $dbal = fmod($d, $curdays);

                                        $mtoadd = intdiv(($m + $dtoadd), 12);
                                        $mbal = fmod(($m + $dtoadd), 12);

                                        $totaly = $y + $mtoadd;
                                        ?>
                                        <tr>
                                            <td class="text-right" colspan="6">Total Period: </td>
                                            <td class="text-center"><?= $totaly . ' Year ' . $mbal . ' Month ' . $dbal . ' Day ' ?></td>
                                        <?php
                                    }
                                        ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanela" class="tab-pane fade" id="tab_content5a" aria-labelledby="profile-tab">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped">

                                    <?php
                                    if ($biodata->allSandangan) {
                                        $bil1 = 1;
                                    ?>
                                        <tr>
                                            <th class="text-center" style="width: 30%;">Position</th>
                                            <th class="text-center">Appointment Status</th>
                                            <th class="text-center">Appointment Type</th>
                                            <th class="text-center" style="width: 15%;">Start Position</th>
                                        </tr>
                                        <?php foreach ($biodata->allSandangan as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= $l->gredJawatan ? $l->gredJawatan->fname : ''; ?></td>
                                                <td class="text-center"><?= $l->sandangan_id ? $l->statusSandangan->sandangan_name : ''; ?></td>
                                                <td class="text-center"><?= $l->ApmtTypeCd ? $l->jenisLantikan->ApmtTypeNm : ''; ?></td>
                                                <td class="text-center"><?= $l->start_date ? $l->tarikhMulaSandangan : ''; ?></td>
                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>