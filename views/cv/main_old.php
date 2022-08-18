<div class="x_panel">
    <div class="col-md-3 col-sm-12 col-xs-12 profile_left"> 
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(SHA1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
            </div>
        </div> 
        <br/> 
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
 
            <br/>
            <div class="table-responsive">
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                <h2><?= strtoupper($biodata->CONm); ?></h2>
                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?php if ($biodata->jawatan->job_category == 1) { ?>
                            TITLE : <?= strtoupper($biodata->gelaran->Title); ?>
                            <br/>
                            ACADEMIC PROGRAM : <?= $biodata->programPengajaran ? $biodata->programPengajaran->NamaProgram : '-'; ?>
                            <br/>
                        <?php } ?>
                        <i class="fa fa-phone-square user-profile-icon"></i> <?= $biodata->COHPhoneNo; ?> |
                        <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?> <br/>
                        <i class="fa fa-user user-profile-icon"></i> <?= $biodata->jawatan->fname; ?> |
                        <i class="fa fa-bookmark user-profile-icon"></i> <?= $biodata->department->fullname; ?>
                    </th> 
                </tr>
                </thead>
                <tbody>

                    <tr> 
                        <th style="width:20%">ICNO</th>
                        <td style="width:20%"><?= $biodata->ICNO; ?></td> 
                        <th>UMSPER</th>
                        <td><?= $biodata->COOldID; ?></td>  

                    </tr>
                    <tr> 
                        <th style="width:20%">Address</th>
                        <td style="width:20%"><?= $biodata->alamatTetap ? $biodata->alamat->alamatPenuh : '-'; ?></td>
                        <th>State</th>
                        <td><?php
                            if ($biodata->COBirthPlaceCd) {
                                echo $biodata->tempatLahir->State;
                            }
                            ?></td> 
                    </tr>
                    <tr> 

                        <th style="width:20%">Date of Birth</th>
                        <td style="width:20%"><?= $biodata->displayBirthDt; ?></td>
                        <th style="width:20%">Gender</th>
                        <td style="width:20%"><?= $biodata->jantina->GenderBI; ?></td>

                    </tr>
                </tbody>
            </table> 
            </div> 
        <br/>

    </div>
</div>
<br/>

<?php if ($biodata->jawatan->job_category == 1) { ?>

    <center>
        <a title="Personal Details" class="btn btn-app" style="color: purple;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=personal'; ?>">
            <i class="fa fa-universal-access"></i> Personal..
        </a>
        <a title="Teaching & Supervision" class="btn btn-app" style="color: orange;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=teaching'; ?>">
            <i class="fa fa-users"></i> Teaching
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
        <a title="Outreaching" class="btn btn-app" style="color: crimson;" href="<?= 'view-cv?id=' . SHA1($biodata->ICNO) . '&title=consultancy'; ?>">
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
    </center>
    <br/>
<?php } ?>

