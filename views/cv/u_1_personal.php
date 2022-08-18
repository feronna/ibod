<?php

use dosamigos\chartjs\ChartJs;
use kartik\tabs\TabsX;
use yii\helpers\Html;
?>
<?php echo $this->render('menu'); ?>  
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title"> 
                <p style="font-size:18px;font-weight: bold;">PROFILE</p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <div class="flex"> 
                    <img class="img-circle profile_img" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(SHA1($biodata->ICNO)); ?>.jpeg" width="100" height="140">

                </div>
                <h2 class="name text-center"><i class="fa fa-user-circle user-profile-icon"></i> &nbsp;&nbsp;<?= strtoupper($biodata->CONm); ?></h2>  

                <?php if ($biodata->jawatan->job_category == 1) { ?>
                    <div class="col-md-12"> 
                        <strong><small><i>ACADEMIC PROGRAM :</i></small></strong><br/> 
                    </div>     
                <?php } ?>
                <div class="rows">
                    <div class="col-md-12 col-sm-12 col-xs-12 hidden-small"> 
                        <table class="countries_list">
                            <tbody>
                                <?php if ($biodata->jawatan->job_category == 1) { ?>
                                    <tr>
                                        <td> <i class="fa fa-book user-profile-icon"></i> <strong><small><?= $biodata->programPengajaran ? $biodata->programPengajaran->NamaProgram : '-'; ?></small></strong></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td> <i class="fa fa-info-circle user-profile-icon"></i> <strong><small>ID:</small></strong> <?= $biodata->ICNO; ?></td>
                                </tr>
                                <tr>
                                    <td> <i class="fa fa-address-book user-profile-icon"></i> <strong><small>UMS ID:</small></strong> <?= $biodata->COOldID; ?></td>
                                </tr>
                                <tr>
                                    <td> <i class="fa fa-map-marker user-profile-icon"></i> 
                                         <?php
                                        if ($biodata->alamatTetap) {
                                            echo $biodata->alamatTetap->displayDaerah . ',' . $biodata->alamatTetap->DisplayNegeri;
                                        } elseif ($biodata->alamatSemasa) {
                                            echo $biodata->alamatSemasa->displayDaerah . ',' . $biodata->alamatSemasa->DisplayNegeri;
                                        } elseif ($biodata->alamatSuratmenyurat) {
                                            echo $biodata->alamatSuratmenyurat->displayDaerah . ',' . $biodata->alamatSuratmenyurat->DisplayNegeri;
                                        } elseif ($biodata->alamatLain2) {
                                            echo $biodata->alamatLain2->displayDaerah . ',' . $biodata->alamatLain2->DisplayNegeri;
                                        } elseif (empty($biodata->rekodAlamat)) {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-flag user-profile-icon"></i> <?= $biodata->displayWarganegara; ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-phone-square user-profile-icon"></i> <?= $biodata->COHPhoneNo; ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?> </td>
                                </tr>

                            </tbody>
                        </table> 
                    </div>
                </div>

                <?php if ($biodata->jawatan->job_category == 1) { ?>

                    <center>  
                        <div class="rows"> 
                            <ul class="to_do"> 
                                <strong>  
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <li><input type="checkbox" class="flat"> Scopus </li>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <li><input type="checkbox" class="flat"> Google Scholar</li>
                                    </div>
                                </strong>
                            </ul>
                            <div class="col-md-3 col-sm-3 col-xs-3"> 
                                <article class="media event">
                                    <a class="pull-left date" style="background-color:#3d5975"> 
                                        <p class="day"><?= $biodata->scopus ? $biodata->scopus->Citations : '-'; ?></p>
                                        <p class="month"><small>Sitasi</small></p>
                                    </a>
                                </article>
                            </div>  
                            <div class="col-md-3 col-sm-3 col-xs-3"> 
                                <article class="media event">
                                    <a class="pull-left date" style="background-color:#3d5975;"> 
                                        <p class="day"><?= $biodata->scopus ? $biodata->scopus->h_index : '-'; ?></p>
                                        <p class="month"><small>H-index</small></p>
                                    </a>
                                </article>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3"> 
                                <article class="media event">
                                    <a class="pull-left date" style="background-color:#3d5975;"> 
                                        <p class="day"><?= $biodata->googleScholar ? $biodata->googleScholar->Citations : '-'; ?></p>
                                        <p class="month"><small>Sitasi</small></p>
                                    </a>
                                </article>
                            </div>  
                            <div class="col-md-3 col-sm-3 col-xs-3"> 
                                <article class="media event">
                                    <a class="pull-left date" style="background-color:#3d5975;"> 
                                        <p class="day"><?= $biodata->googleScholar ? $biodata->googleScholar->h_index : '-'; ?></p>
                                        <p class="month"><small>H-index</small></p>
                                    </a>
                                </article> 
                                <br/>
                            </div>
                        </div>
                    </center> 
                <?php } ?> 


            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-8 ">
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <?php if ($biodata->jawatan->job_category == 1) { ?>
                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title"> 
                                    <p style="font-size:18px;font-weight: bold;">ACADEMIC RECORD</p>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content text-center">   
                                    <a title="Personal Details" class="btn btn-app" style="color: purple;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=personal'; ?>">
                                        <i class="fa fa-universal-access"></i> Personal..
                                    </a>
                                    <a title="Teaching" class="btn btn-app" style="color: orange;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=teaching'; ?>">
                                        <i class="fa fa-users"></i> Teaching
                                    </a> 
                                    <a title="Blended Learning" class="btn btn-app" style="color: blueviolet;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=blended'; ?>">
                                        <i class="fa fa-users"></i> Blended
                                    </a> 
                                    <a title="Research" class="btn btn-app" style="color: green;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=research'; ?>">
                                        <i class="fa fa-search"></i> Research
                                    </a>
                                    <a title="Consultancy" class="btn btn-app" style="color: red;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=supervisory'; ?>">
                                        <i class="fa fa-hand-rock-o"></i> Supervision
                                    </a>
                                    <a title="Publication" class="btn btn-app" style="color: darkred;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=publication'; ?>">
                                        <i class="fa fa-file-powerpoint-o"></i> Publication
                                    </a>
                                    <a title="Conferences" class="btn btn-app" style="color: blueviolet;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=conferences'; ?>">
                                        <i class="fa fa-newspaper-o"></i> Conferences
                                    </a> 
                                    <a title="Designer Competition" class="btn btn-app" style="color: royalblue;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=designer'; ?>">
                                        <i class="fa fa-newspaper-o"></i> Designer 
                                    </a>
                                    <a title="Innovation" class="btn btn-app" style="color: hotpink;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=innovation'; ?>">
                                        <i class="fa fa-newspaper-o"></i> Innovation
                                    </a> 
                                    <a title="Technology Innovation" class="btn btn-app" style="color: gold;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=innovation_it'; ?>">
                                        <i class="fa fa-newspaper-o"></i> Innovation (IT)
                                    </a>
                                    <a title="Consultancy" class="btn btn-app" style="color: crimson;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=consultancy'; ?>">
                                        <i class="fa fa-file-o"></i> Consultancy
                                    </a>
                                    <a title="Services" class="btn btn-app" style="color: blue;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=services'; ?>">
                                        <i class="fa fa-file-o"></i> Services
                                    </a> 
                                    <a title="Esteem & Leadership" class="btn btn-app" style="color: orangered;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=esteem'; ?>">
                                        <i class="fa fa-file-o"></i> Esteem
                                    </a>
                                    <a title="Download CV" class="btn btn-app" style="color: brown;" href="<?= 'download-resume?id=' . SHA1($biodata->ICNO); ?>"  target="_blank"> 
                                        <i class="fa fa-download"></i> Download
                                    </a>   
                                </div>
                            </div> 
                        </div>
                    </div>
                <?php } ?>

                <div class="x_panel">
                    <div class="x_title"> 
                        <p style="font-size:18px;font-weight: bold;">ACTUAL POST</p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            <div class="col-md-6 hidden-small"> 
                                <table class="countries_list">
                                    <tbody>
                                        <tr>
                                            <td>Grade</td>
                                            <td class="fs15 fw700 text-right"><?= $biodata->jawatan->gred; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Designation</td>
                                            <td class="fs15 fw700 text-right"><?= $biodata->jawatan->fname; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td class="fs15 fw700 text-right"><?= $biodata->statusLantikan->ApmtStatusNm; ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Date Assigned</td>
                                            <td class="fs15 fw700 text-right">
                                                <?php
                                                if ($biodata->statLantikan == 1) {//tetap
                                                    echo $biodata->SandanganCTetap ? $biodata->getTarikhBI($biodata->SandanganCTetap->start_date) : '-';
                                                } else {
                                                    echo $biodata->sandanganCKontrak ? $biodata->getTarikhBI($biodata->sandanganCKontrak->start_date) : '-';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Confirmation date</td>
                                            <td class="fs15 fw700 text-right">
                                                <?php
                                                if ($biodata->confirmDt) {
                                                    echo $biodata->confirmDt ? $biodata->getTarikhBI($biodata->confirmDt->ConfirmStatusStDt) : '-';
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div> 
                            <div class="col-md-6 hidden-small"> 
                                <table class="countries_list">
                                    <tbody>
                                        <tr>
                                            <td>Permanent Appointment </td>
                                            <td class="fs15 fw700 text-right">
                                                <?php
                                                if ($biodata->statLantikan == 1) {//tetap
                                                    echo $biodata->servPeriodPermanentBI;
                                                } else {
                                                    echo '-';
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Current Positions</td>
                                            <td class="fs15 fw700 text-right"><?= $biodata->servPeriodCPositionBI; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date appointed to current position</td>
                                            <td class="fs15 fw700 text-right">
                                                <?php
                                                if ($biodata->statLantikan == 1) {//tetap
                                                    echo $biodata->SandanganCTetap ? $biodata->getTarikhBI($biodata->SandanganCTetap->start_date) : '-';
                                                } else {
                                                    echo $biodata->sandanganCKontrak ? $biodata->getTarikhBI($biodata->sandanganCKontrak->start_date) : '-';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Location</td>
                                            <td class="fs15 fw700 text-right">
                                                <?= $biodata->penempatan ? $biodata->penempatan->department->fullname : ' ' ?> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if ($biodata->jawatan->job_category == 1) { ?>
                                    <br/><br/><br/> 
                                <?php } ?>
                                <?php if ($biodata->jawatan->job_category == 2) { ?>
                                    <br/><br/><br/> 
                                    <div class="text-right">
                                        <a title="Download CV" class="btn btn-app" style="color: #00193a;" href="<?= 'download-resume?id=' . SHA1($biodata->ICNO); ?>"  target="_blank"> 
                                            <i class="fa fa-download"></i> Download  </a> 
                                    </div>
                                <?php } ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title"> 
                <p style="font-size:18px;font-weight: bold;">SERVICES RECORD</p>
                <div class="clearfix"></div>
            </div> 
            <?php
            $items = [
                [
                    'label' => 'Education Background',
                    'content' => $this->render('u_1_personal_educational_background', [
                        'biodata' => $biodata,
                    ]),
                    'active' => true
                ],
                [
                    'label' => 'Professional Expertise',
                    'content' => $this->render('u_1_personal_professional_expertise', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Honour(S)',
                    'content' => $this->render('u_1_personal_honour', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Career History',
                    'content' => $this->render('u_1_personal_career_history', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Attendance Report',
                    'content' => $this->render('u_1_personal_attendance_report', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Professional Development',
                    'content' => $this->render('u_1_personal_professional_development', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'LNPT',
                    'content' => $this->render('u_1_personal_lnpt', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Placement History',
                    'content' => $this->render('u_1_personal_placement_history', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Administration Position',
                    'content' => $this->render('u_1_personal_administration_position', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Appointment Position History',
                    'content' => $this->render('u_1_personal_appointment_position', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Membership',
                    'content' => $this->render('u_1_personal_membership', [
                        'biodata' => $biodata,
                    ]),
                ],
                [
                    'label' => 'Clinical Certificate',
                    'content' => $this->render('u_1_personal_medical_certificate', [
                        'biodata' => $biodata,
                    ]),
                ],
            ];

            echo TabsX::widget([
                'items' => $items,
                'position' => TabsX::POS_ABOVE,
                'align' => TabsX::ALIGN_CENTER,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>
        </div>
    </div>
</div>