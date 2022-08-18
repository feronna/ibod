 <?php 
 use yii\helpers\Html;
 
 error_reporting(0);
 ?> 
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>


<div class="x_panel">
    <div class="x_title">
        <h5 ><strong><i class="fa fa-user"></i>SEMAKAN MYPORTFOLIO SEMASA</strong></h5>
    
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
                   
                    </tr>     
                </tbody>
            </table> 
        </div> 
        <br/>
    </div>
</div>


 <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> SENARAI DOKUMEN MYPORTFOLIO</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
             <div class="x_content">
                      
            <div class="table-responsive">
      
                
        
                <table class="table table-striped table-sm jambo_table">
                    
                        <thead>

                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">KETERANGAN/CATATAN</th>
                            <th class="column-title">JAFPIB</th>
                            <th class="column-title">TARIKH KELULUSAN</th>
                            <th class="column-title">STATUS DOKUMEN </th>
                       
                            
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($models as $key => $models){ ?>
                            <tr> 
                                <td><?= $key+1 ?></td>
                                
                        <td style="text-decoration: underline"><?php {
                        echo  Html::a($models->name, ["maklumat-pegawai", 'id' => $models->id], ['target' => '_blank']);
                        }?></td>
                                
                            <td><?= $models->department->fullname ?></td>
                      
                                <td> <?php if($models->tarikh_perakuan_kj == null){
                           echo '<span class="label label-danger">BELUM DIHANTAR</span>';
                        }
                            else{
                            echo $models->tarikh_perakuan_kj;
                          }?></td>
                               <td> <?php if($models->status_hantar_portfolio == null){
                           echo '<span class="label label-danger">DERAF</span>';
                        }
                            else{
                             echo '<span class="label label-success">TELAH DIHANTAR</span>';
                          }?></td>
                
                          
                            </tr>
                   
                        </tbody>
         <?php }?>
                    </table>

                </div>
            </div>
    </div>
</div>

        

        
       
