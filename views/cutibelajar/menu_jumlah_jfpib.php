<?php

use app\models\cbelajar\TblPengajian;
use app\models\hronline\Tblprcobiodata;
$userID = Yii::$app->user->getId();
                $test = Tblprcobiodata::find()->where(['ICNO' => $userID])->one();

$department = app\models\hronline\Department::find()->where(['chief'=>$userID])->one();
$sabatikal = TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>99])->one();

$posdok = TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>200])->one();

$sarjana = TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>20])->one();

$phd = TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                     ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>1])->one();
$dok = TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                     ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>201])->one();
$kepakaran = TblPengajian::
                find()->joinWith('kakitangan.department')
                ->joinWith('kakitangan.jawatan')
                ->where(['chief' => $userID])
                ->orWhere(['department.pp' => $userID])
                     ->orWhere(['tblprcobiodata.DeptId' => $test->DeptId])

//                ->andWhere(['tahun' => $currentYear])
                ->andWhere(['job_category' => [1]])
                ->andWhere(['<>', 'tblprcobiodata.Status', '6'])
                ->andWhere(['cb_tbl_pengajian.status' => 1])->
                  andWhere(['cb_tbl_pengajian.HighestEduLevelCd'=>202])->one();
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel"> 
 <div class="x_title">
            <h6><strong><i class="fa fa-bar-chart"></i> JUMLAH PENGAJIAN YANG DILULUSKAN</strong></h6>
            
            
            <div class="clearfix"></div>
        </div>
            <div class="x_content">  
<!--                <strong><p style="color:blue">JUMLAH KESELURUHAN: <span class="label label-info">  <?//=
                                     TblPengajian::TotalbyDiploma(1) + TblPengajian::TotalbyPhdfakulti(1)
                                    + TblPengajian::TotalbyPosfakulti(1)
                                    + TblPengajian::TotalbySabatikalfakulti(1) + TblPengajian::TotalbySarjanafakulti(1)
                                    + TblPengajian::TotalbySarjanakepakaranfakulti(1) ; ?> ORANG</span></p></strong>-->
                <ul class="list-inline list-unstyled">
                    <?php if($phd)
                    {?>
                    <li id="card-tweets">
                        <span class="name"><a href=" " class="btn btn-primary btn-sm"> DOKTOR FALSAFAH <i class="fa fa-graduation-cap"></i></a> </span>
                        <strong><span class="value text-info"> <?= TblPengajian::TotalbyPhdfakulti(1); ?> ORANG </span></strong>
                        
                      
                    </li><?php }?>
                    
                    
                    
                    <?php if($kepakaran){?>
                    <li>
                        <span class="name"><a href=" " class="btn btn-warning btn-sm"> SARJANA KEPAKARAN <i class="fa fa-graduation-cap"></i></a> </span>
                          <strong><span class="value text-info"> <?= TblPengajian::TotalbySarjanakepakaranfakulti(1); ?> ORANG
                              </span></strong>

                    </li><?php }
                    elseif($department->id == 136){?>
                    <li class="hidden-phone">
                        <span class="name"><a href=" " class="btn btn-success btn-sm"> LATIHAN INDUSTRI <i class="fa fa-graduation-cap"></i></a> </span>
                        <strong><span class="value text-info"><?= TblPengajian::TotalbyLatihanfakulti(1); ?> ORANG  </span></strong>
                    </li>
                    
                    <?php }?>
                    <?php if($sarjana){?>
                     <li>
                          <span class="name"><a href=" " class="btn btn-info btn-sm"> SARJANA <i class="fa fa-graduation-cap"></i></a> </span>
                          <strong><span class="value text-info"> <?= TblPengajian::TotalbySarjanafakulti(1); ?> ORANG </span></strong>
                    </li><?php }?>
                    <?php if($sabatikal)
                    {?>
                    <li>
                          <span class="name"><a href=" " class="btn btn-success btn-sm"> CUTI SABATIKAL <i class="fa fa-graduation-cap"></i></a> </span>
                          <strong><span class="value text-info"> <?= TblPengajian::TotalbySabatikalfakulti(1); ?> ORANG </span></strong>
                    </li>
                    <?php }?>
                     <?php if($posdok)
                    {?>
                    <li>
                          <span class="name"><a href=" " class="btn btn-success btn-sm"> POS DOKTORAL <i class="fa fa-graduation-cap"></i></a> </span>
                          <strong><span class="value text-info"> <?= TblPengajian::TotalbyPosfakulti(1); ?> ORANG </span></strong>
                    </li>
                    <?php }?>
                       <?php if($dok)
                    {?>
                    <li>
                          <span class="name"><a href=" " class="btn btn-success btn-sm"> POS BASIK <i class="fa fa-graduation-cap"></i></a> </span>
                          <strong><span class="value text-info"> <?= TblPengajian::TotalbyDokfakulti(1); ?> ORANG </span></strong>
                    </li>
                    <?php }?>
                    
                   
                </ul>


            </div>
        </div>
    </div></div>
