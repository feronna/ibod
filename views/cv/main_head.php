<div class="x_panel">

    <u><h2><strong>CANDIDATE INFORMATION</strong></h2></u>

    <div class="col-md-3 col-sm-12 col-xs-12 profile_left"> 
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
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
                            <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?><br/>
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
                        <td style="width:20%"<?php
                        if ($biodata->alamatTetap) {
                            echo $biodata->alamatTetap->alamatPenuh;
                        } elseif ($biodata->alamatSemasa) {
                            echo $biodata->alamatSemasa->alamatPenuh;
                        } elseif ($biodata->alamatSuratmenyurat) {
                            echo $biodata->alamatSuratmenyurat->alamatPenuh;
                        } elseif ($biodata->alamatLain2) {
                            echo $biodata->alamatLain2->alamatPenuh;
                        } elseif (empty($biodata->rekodAlamat)) {
                            echo 'N/A';
                        }
                        ?></td>
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

