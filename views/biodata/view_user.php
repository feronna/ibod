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
            <div class="row ">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $model->gelaran->Title ." ". ucwords(strtolower($model->CONm)) ?></div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                </div>
                <div class="row ">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->NamaJawatan($model->ICNO) ?></div>
                </div>
                <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStatusLantikan ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartToEndLantikBiodata ?></div>
                    </div>
            </div> </br>

            <div class="well"> 
                <div class="row ">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                            <tr>
                                <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Biodata', ['lihatbiodata']) ?></td>

                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-address-card-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Alamat', ['alamat/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-mortar-board" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pendidikan', ['pendidikan/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-language" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Bahasa', ['bahasa/view']) ?></td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                            <tr>
                                <td class="text-center"><i class="fa fa-sitemap" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Keahlian', ['badan-profesional/view']) ?></td>
                            </tr> 
                            <tr>
                                <td class="text-center"><i class="fa fa-trophy" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Anugerah', ['anugerah/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-cc-visa" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Paspot & Permit Kerja', ['pasport-permit/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-id-card-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Lesen', ['lesen/view']) ?></td>
                            </tr>


                        </table>
                    </div> 


                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table> 
                            <tr>
                                <td class="text-center"><i class="fa fa-credit-card" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Akaun', ['akaun/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-wheelchair" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Kecacatan', ['kecacatan/view']) ?></td>
                            </tr>
                            <tr> 
                                <td class="text-center"><i class="fa fa-building" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pengalaman Kerja', ['pengalamankerja/view']) ?></td>
                            </tr>
                            <tr> 
                                <td class="text-center"><i class="fa fa-medkit" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Sejarah Perubatan', ['sejarahperubatan/view']) ?></td>
                            </tr>
                            


                        </table>
                    </div> 


                    <div class="col-lg-3 col-md-6  col-sm-6 col-xs-12">
                        <table>
                            <tr> 
                                <td class="text-center"><i class="fa fa-users" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Keluarga', ['keluarga/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-tasks" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Bidang Kepakaran', ['bidangkepakaran/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-plus-square" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Program Vaksinasi', ['vaksinasi/index']) // Html::a('Program Vaksinasi', ['vaksinasi/view']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-plus-square" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Kelayakan Perubatan', ['kelayakan-perubatan/view']) ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>














