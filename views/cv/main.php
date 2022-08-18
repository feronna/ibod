<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <p style="font-size:18px;font-weight: bold;"><i class="fa fa-user-circle user-profile-icon"></i> &nbsp;&nbsp;<?= strtoupper($biodata->CONm); ?></P> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content">   

                <?php if ($biodata->jawatan->job_category == 1) { ?>
                    <div class="col-md-12"> 
                        <strong><small><i>ACADEMIC PROGRAM :</i></small></strong><br/> 
                    </div>     
                <?php } ?>
                <div class="rows">
                    <div class="col-md-12 hidden-small"> 
                        <table class="countries_list">
                            <tbody>
                                <?php if ($biodata->jawatan->job_category == 1) { ?>
                                    <tr>
                                        <td> <i class="fa fa-book user-profile-icon"></i> <strong><small><?= $biodata->programPengajaran ? $biodata->programPengajaran->NamaProgram : '-'; ?></small></strong></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td> <i class="fa fa-bookmark user-profile-icon"></i>  <?= $biodata->jawatan->fname; ?> </td>
                                </tr>
                                <tr>
                                    <td> <i class="fa fa-check-circle user-profile-icon"></i>  <?= $biodata->statusLantikan->ApmtStatusNm; ?> </td>
                                </tr>
                                <tr>
                                    <td> <i class="fa fa-map-marker user-profile-icon"></i>  <?= $biodata->penempatan ? $biodata->penempatan->department->fullname : ' ' ?> </td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div> 
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
                                    <p style="font-size:18px;font-weight: bold;">ACADEMIC RECORD</P> 
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


            </div>
        </div>

    </div>
</div>