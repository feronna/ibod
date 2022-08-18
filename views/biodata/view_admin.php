<?php

use yii\helpers\Html;

$this->title = 'Maklumat Dan Rekod Kakitangan';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
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
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->NamaJawatan($model->ICNO) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandanganPerkhidmatan  ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->displayStatusLantikan ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartToEndLantikBiodata ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartDateStatus ?></div>
                    </div>
                </div>
            </div> </br>

            <div class="well well-lg"> 
                <div class="row ">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                            <tr>
                                <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Biodata', ['lihatbiodatakakitangan', 'id' => $model->ICNO]) ?></td>

                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-address-card-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Alamat', ['alamat/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-mortar-board" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pendidikan', ['pendidikan/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-language" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Bahasa', ['bahasa/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                            <tr>
                                <td class="text-center"><i class="fa fa-sitemap" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Keahlian', ['badan-profesional/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-trophy" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Anugerah', ['anugerah/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-cc-visa" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Paspot dan Permit Kerja', ['pasport-permit/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-id-card-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Lesen', ['lesen/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                        </table>
                    </div> 


                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table> 
                            <tr>
                                <td class="text-center"><i class="fa fa-credit-card" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Akaun', ['akaun/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-wheelchair" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Kecacatan', ['kecacatan/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>

                            <tr> 
                                <td class="text-center"><i class="fa fa-building" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pengalaman Kerja', ['pengalamankerja/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr> 
                                <td class="text-center"><i class="fa fa-medkit" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Sejarah Perubatan', ['sejarahperubatan/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                        </table>
                    </div> 


                    <div class="col-lg-3 col-md-6  col-sm-6 col-xs-12">
                        <table>
                            <tr> 
                                <td class="text-center"><i class="fa fa-users" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Keluarga', ['keluarga/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-tasks" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Bidang Kepakaran', ['bidangkepakaran/adminview', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-gears" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Penetapan Pengguna', ['penetapanpengguna', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                             <tr>
                                <td class="text-center"><i class="fa fa-plus-square" aria-hidden="true"></i></td>
                                <td>&nbsp;<?=  Html::a('Program Vaksinasi', ['vaksinasi/admin-view-status-vaksinasi','icno'=>$model->ICNO]) ?></td>
                            </tr>
                             <tr>
                                <td class="text-center"><i class="fa fa-plus-square" aria-hidden="true"></i></td>
                                <td>&nbsp;<?=  Html::a('Kelayakan Perubatan', ['kelayakan-perubatan/admin-view','icno' => $model->ICNO]) ?></td>
                            </tr>
                        </table>
                    </div>

                </div> <!-- div for row-->
            </div> <!-- div for well-->

        </div>
    </div>
</div>














