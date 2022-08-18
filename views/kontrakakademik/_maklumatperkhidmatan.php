<style>
    .kotak{
    height:100%;
    background-color: #eeeeee;
    opacity: 1; 
    padding: 10px;
    color: #555555;
    border: 1px solid #ccc;
    word-wrap: break-word}
</style>
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Service Particulars</strong></h2>
                   <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>   
                </div>
            <div class="x_content">
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Post & Grade <span class="required"></span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="kotak">
                            <?= "(".$model->kakitangan->jawatan->gred.") ".$model->kakitangan->jawatan->namaenglish?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU <span class="required"></span></label>
                       <div class="col-md-9 col-sm-9 col-xs-12">
                           <div class="kotak">
                            <?= $model->kakitangan->department->fullname?></div><br>
                       </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Programme <span class="required"></span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="kotak">
                            <?= $model->kakitangan->programPengajaran->NamaProgram.' ('.$model->kakitangan->programPengajaran->KodProgram.')'?></div><br>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Appointment <span class="required"></span></label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                           <div class="kotak">
                            <?= $model->startdatelantik?></div><br>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date of Expiry <span class="required"></span></label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                           <div class="kotak">
                            <?= $model->enddatelantik?></div><br>
                        </div>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Duration<span class="required"></span></label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                           <div class="kotak">
                            <?= $model->tempoh?></div><br>
                        </div>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Application is for <span class="required"></span></label>
                       <div class="col-md-3 col-sm-3 col-xs-12">
                           <div class="kotak">
                            <?= $countlantikan.' Extension'?></div><br>
                       </div>
                   </div>
                </div>
            </div>
            </div>
        </div>