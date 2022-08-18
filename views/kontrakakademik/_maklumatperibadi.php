
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Applicant Particulars</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    
                    
                    <div class="col-md-2 col-sm-2  profile_left"> 
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->icno)); ?>.jpeg" width="150" height="180"></center>
                        </div>
                    </div> 
                    <br/> 
                </div>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Full Name <span class="required"></span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="kotak">
                                    <?= $model->kakitangan->CONm?>
                                </div><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Identification No / Passport No <span class="required"></span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="kotak">
                                    <?= $model->icno?>
                                </div><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="kotak">
                                    <?= $model->kakitangan->COOldID?>

                                </div><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Age <span class="required"></span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="kotak">
                                    <?= $model->kakitangan->umur.' Years Old'?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>