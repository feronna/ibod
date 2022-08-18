<div class="row"  
<!--     style="display: <?php if(Yii::$app->user->getId() === $model->app_by && $model->status === '2' 
                || Yii::$app->user->getId() === $model->app_by && $model->status != '2' && ($admin === 0 && $meeting===0)){echo 'none';}?>"-->
     > 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> HR's Endorsement</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status of Endorsement <span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $model->viewstatusbsmakademik;?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Proposed Renewal Period of Contract<span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" class="form-control" value="<?php echo $model->tempoh_l_bsm;?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date<span class="required"></span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?php echo $model->tarikhbsma;?>" disabled="disabled">
                        </div>
                    </div>
                </div>
            </div>
        </div>