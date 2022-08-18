<?php

use yii\helpers\Html;
?>  
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:15px;font-weight: bold;">APPLICATION INFORMATION</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">  
        <table class="table" style="width:100%;">  
            <tr> 
                <td style="width:40%">Name/Nama</td>
                <td>: <?= $biodata->CONm; ?></td>
            </tr>
            <tr> 
                <td>Current Position/Jawatan Semasa</td>
                <td>: <?= $biodata->jawatan->fname; ?></td>
            </tr>
            <tr> 
                <td>Position Apply/Jawatan dimohon</td>
                <td>: <?= $gred; ?></td>
            </tr>
        </table>  
        <?php if ($biodata->jawatan->job_category == 1) { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Why did you apply this position?/ Kenapa anda memohon jawatan ini: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?= $model->why_applied; ?>
                </div>  
            </div> 

        <?php } else { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Please state the factors that can qualify you for this position/Sila nyatakan faktor-faktor yang boleh melayakan anda menjawat jawatan ini: <span class="required" style="color:red;">*</span> <br/><br/>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?= $model->qualification; ?> 
                </div>  
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Please state your achievements during your tenure in the current position/Sila nyatakan pencapaian anda sepanjang tempoh berada dalam jawatan semasa: <span class="required" style="color:red;">*</span> <br/><br/>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?= $model->accomplishment; ?> 
                </div>  
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">If you held this position, what would you contribute to the benefit of the university/Jika anda menjawat jawatan ini, apakah yang akan anda sumbangkan untuk kepentingan universiti: <span class="required" style="color:red;">*</span> <br/><br/>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?= $model->contribute; ?> 
                </div>  
            </div> 
        <?php } ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Already declared a property? Sudah istihar harta?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12"> 
                <?php
                if ($model->sahHarta) {
                    echo $model->sahHarta->ADDeclDt;
                } else {
                    echo '- No information';
                }
                ?>
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Have you ever taken disciplinary action?/Adakah anda pernah diambil tindakan tatatertib?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php
                if ($model->tatatertib_status == 1) {
                    echo 'Never';
                } else {
                    echo 'Yes';
                }
                ?> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">If Yes, state type of action/Jika Ya, nyatakan jenis hukuman:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $model->tatatertib_state ? $model->tatatertib_state : '-'; ?> 
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Did you take the General and Special Induction Course?/Sudahkah anda mengambil Kursus Induksi Umum dan Khusus?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  

                <?php
                if ($model->induksi_status == 1) {
                    echo 'Taken';
                } else {
                    echo 'Not yet';
                }
                ?> 
            </div> 
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">If Taken, when?/Jika Sudah, bila?:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $model->induksi_date ? $model->induksi_date : '-'; ?> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Result/Keputusan: 
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  

                <?php
                if ($model->induksi_result == 1) {
                    echo 'Fail';
                } elseif ($model->induksi_result == 2) {
                    echo 'Pass';
                }else{
                    echo '-';
                }
                ?> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">If given the exemption, state the reasons and evidence exclusion/Jika diberi pengecualian, nyatakan sebab dan bukti pengecualian:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $model->induksi_skip ? $model->induksi_skip : '-'; ?>
            </div> 
        </div>   
    </div>
</div>  
<?php if ($biodata->jawatan->job_category == 2) { ?>
    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">SENARAI 5 TUGAS UTAMA SEKARANG</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th>  
                    <th style="width: 95%;">Tugasan</th>  

                </tr> 

                <?php
                $counter = 0;
                $JobDetails = $model->jobDetails;
                if ($JobDetails) {
                    foreach ($JobDetails as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>  
                            <td><?= $record->jobdetails ? $record->jobdetails : ' '; ?> </td>    
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="2" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div> 
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">SENARAI TUGAS UTAMA (Sumber senarai tugas LNPT)</p> 
            <div class="clearfix"></div>
        </div>  

        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%">  
                <tr>  
                    <th>No.</th>  
                    <th width="10%">Tahun</th>
                    <th width="85%">Tugas</th>  

                </tr>  
                <?php
                $counter = 1;
                $recordLnpt = $model->getRecordLnpt($biodata->ICNO);
                if ($recordLnpt) {
                    foreach ($recordLnpt as $lnpt) {
                        ?> 

                        <tr> 
                            <td><?= $counter; ?></td> 
                            <td> <?= $lnpt->lpp ? $lnpt->lpp->tahun : ''; ?>  </td>  
                            <td><?= $lnpt->senarai_tugas ? $lnpt->senarai_tugas : ''; ?></td>

                        </tr> 
                        <?php
                        $counter = $counter + 1;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">INOVASI DALAM KERJA (Di gred jawatan semasa)</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 10%;">Tahun</th>
                    <th style="width: 15%;">JSPIU</th>
                    <th style="width: 30%;">Unit/Seksyen/Bahagian</th>  
                    <th style="width: 40%;">Inovasi</th>  

                </tr> 

                <?php
                $counter = 0;
                $Innovation = $model->innovation;
                if ($Innovation) {
                    foreach ($Innovation as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $record->year ? $record->year : ' '; ?> </td> 
                            <td><?= $record->department ? $record->department->fullname : ' '; ?> </td> 
                            <td><?= $record->unit ? $record->unit : ' '; ?> </td> 
                            <td><?= $record->innovation ? $record->innovation : ' '; ?> </td>    
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">KEMAHIRAN YANG DIMILIKI SEPANJANG BERKHIDMAT DI UMS</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th>  
                    <th style="width: 95%;">Kemahiran</th>   

                </tr> 

                <?php
                $counter = 0;
                $Skills = $model->skills;
                if ($Skills) {
                    foreach ($Skills as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $record->skills ? $record->skills : ' '; ?> </td>   
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="2" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">PENGLIBATAN LUAR</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 15%;">Tarikh</th>
                    <th style="width: 30%;">Peringkat</th>  
                    <th style="width: 50%;">Aktiviti lain</th>    

                </tr> 

                <?php
                $counter = 0;
                $ActivitiesOther = $model->activitiesOther;
                if ($ActivitiesOther) {
                    foreach ($ActivitiesOther as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $record->date ? $record->date : ' '; ?> </td> 
                            <td><?= $record->peringkat ? $record->peringkat->output : ' '; ?> </td> 
                            <td><?= $record->other ? $record->other : ' '; ?> </td>    
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">PENJANAAN PENDAPATAN / PENJIMATAN</p> 
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 15%;">Tarikh</th>
                    <th style="width: 80%;">Aktiviti</th>  

                </tr> 

                <?php
                $counter = 0;
                $Income = $model->income;
                if ($Income) {
                    foreach ($Income as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $record->genincome_date ? $record->genincome_date : ' '; ?> </td> 
                            <td><?= $record->genincome_activities ? $record->genincome_activities : ' '; ?> </td>   
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">PENGANJURAN / PENGLIBATAN DALAM PROGRAM / MAJLIS KEBUDAYAAN / ACARA SUKAN</p>  
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 15%;">Tarikh</th>
                    <th style="width: 80%;">Aktiviti</th>      

                </tr> 

                <?php
                $counter = 0;
                $Sports = $model->sports;
                if ($Sports) {
                    foreach ($Sports as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>  
                            <td><?= $record->orgculsports_date ? $record->orgculsports_date : ' '; ?> </td> 
                            <td><?= $record->orgculsports_activities ? $record->orgculsports_activities : ' '; ?> </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">PENGLIBATAN DALAM KUMPULAN PENYELIDIKAN ATAU PENGURUSAN PERALATAN PENYELIDIKAN</p>  
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 15%;">Tarikh</th>
                    <th style="width: 80%;">Aktiviti</th>  

                </tr> 

                <?php
                $counter = 0;
                $Research = $model->research;
                if ($Research) {
                    foreach ($Research as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $record->invresearch_date ? $record->invresearch_date : ' '; ?> </td> 
                            <td><?= $record->invresearch_activities ? $record->invresearch_activities : ' '; ?> </td>  
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">PENULISAN KERTAS KERJA / PEMBENTANG KERTAS KERJA / PENCERAMAH / PEMUDAH CARA</p>  
            <div class="clearfix"></div>
        </div> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 15%;">Tarikh</th>
                    <th style="width: 80%;">Aktiviti</th>    

                </tr> 

                <?php
                $counter = 0;
                $PaperWork = $model->paperWork;
                if ($PaperWork) {
                    foreach ($PaperWork as $record) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $record->paperwork_date ? $record->paperwork_date : ' '; ?> </td> 
                            <td><?= $record->paperwork_activities ? $record->paperwork_activities : ' '; ?> </td>    
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Maklumat</td>      
                    </tr>

                <?php }
                ?>
            </table>
        </div>
    </div>

<?php } ?>