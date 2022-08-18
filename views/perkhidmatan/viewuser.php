<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;

error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Maklumat Dan Rekod Perkhidmatan';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
      
        
          <div class="x_title">
            <h2><strong>Maklumat Dan Rekod Perkhidmatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row text-center" >
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $model->gelaran->Title ." ". ucwords(strtolower($model->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                    </div>
                  
                </div>
            </div> </br>

                   <div class="well well-lg"> 
                <div class="row ">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                 
                            <tr>
                                <td class="text-center"><i class="fa fa-user-circle" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pihak Berkuasa Melantik', ['pihak-berkuasa/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr
                            <tr>
                                <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pihak Berkuasa Pencen', ['pihak-berkuasa-pencen/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-list" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Pengesahan', ['status-pengesahan/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            
                           

                        </table>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                            
                             <tr> 
                                <td class="text-center"><i class="fa fa-bar-chart" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Pencen', ['status-pencen/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                             <tr>
                                <td class="text-center"><i class="fa fa-balance-scale" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Beban Perkhidmatan', ['beban-perkhidmatan/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            
                            <tr>
                                <td class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Jenis Perkhidmatan', ['jenis-perkhidmatan/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>

                          
                         
                                   
                            
                        </table>
                    </div> 


                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table> 
                           
                            <tr> 
                                <td class="text-center"><i class="fa fa-exchange" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pergerakan Gaji', ['pergerakan-gaji/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                             <tr>
                                <td class="text-center"><i class="fa fa-clock-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Waktu Bekerja', ['waktu-bekerja/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                    
                        </table>
                    </div> 


                    <div class="col-lg-3 col-md-6  col-sm-6 col-xs-12">
                        <table>

                           
                             
                             <tr>
                                <td class="text-center"><i class="fa fa-hourglass" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Umur Bersara', ['umur-bersara/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            
                             <tr>
                                <td class="text-center"><i class="fa fa-history" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Sejarah Penempatan', ['sejarah-penempatan/viewuser', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                             

                        </table>
                    </div>

                </div> <!-- div for row-->
            </div> <!-- div for well-->

        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
  <div class="x_panel">
        <div class="x_content">  
                <strong>
                    Sebarang pertanyaan dan kemusykilan mengenai maklumat perkhidmatan sila hubungi talian berikut:<br/><br/>
                    <table>
                        <tr><td width="300px">
                    Hafizah binti Hassan<br/>
                    Penolong Pegawai Teknologi Maklumat<br/>
                    Tel: 088320000 (samb. 1144)
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                            </td>
                        <td width="350px">
                    Puan Rosliah @  Daphne Lawrence<br/>
                    Ketua Pembantu Tadbir <br/>
                    Tel: 088320000 (samb. 1152)  
                        </td></tr>
                    </table>
                </strong>  
        </div>
    </div>
</div>