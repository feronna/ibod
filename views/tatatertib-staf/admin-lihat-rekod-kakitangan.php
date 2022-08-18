 <?php 
 use yii\helpers\Html;
 
 error_reporting(0);
 ?> 

<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-user"></i> MAKLUMAT PERIBADI</strong></h5>
        <p align="right"> 
         
            <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>
        </p> 
        <div class="clearfix"></div>
    </div>
    
    <div class="col-md-3 col-sm-3  profile_left"> 
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
            </div>
        </div> 
        <br/> 
    </div>
    
    <div class="col-md-9 col-sm-9 col-xs-9">
        <div class="col-md-12 col-sm-12 col-xs-12">   
            <br/>
<!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->
                   
            <table class="table" style="width:100%">  
                <thead>
                <tr>
                    <th colspan="4" class="text-center">
                    <h5><?=  strtoupper($biodata->CONm); ?></h5>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="width:20%">ICNO</th> 
                        <td style="width:20%"><?= strtoupper($biodata->ICNO);?></td> 
                        
                        <th>STATUS</th>
                        <td><?= strtoupper($biodata->Status ? $biodata->serviceStatus->ServStatusNm : 'Not Set') ?></td>
                    </tr>
                    <tr> 
                        <th style="width:20%">JAWATAN SEMASA</th>
                        <td style="width:20%"><?= \strtoupper($biodata->jawatan->nama . " (" . $biodata->jawatan->gred . ")"); ?></td> 
                     

                    </tr>
                    <tr>  
                        <th style="width:20%">JABATAN SEMASA</th>
                        <td style="width:20%"><?= strtoupper($biodata->department->fullname);?></td>
                      
                    </tr>
                    <tr> 
                        <th style="width:20%">TARIKH LANTIKAN SEMASA</th>
                        <td style="width:20%"><?= strtoupper($biodata->displayStartSandangan); ?></td>
                       
                    </tr>
                    <tr>  
                        <th style="width:20%">STATUS SANDANGAN</th>
                        <td style="width:20%"><?= strtoupper($biodata->statusSandangan->sandangan_name) ?></td>  
                        <th>STATUS JAWATAN</th>
                        <td><?= strtoupper($biodata->statusLantikan->ApmtStatusNm) ?></td>
                    </tr>     
                </tbody>
            </table> 
        </div> 
        <br/>
    </div>
</div>


