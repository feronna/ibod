<!DOCTYPE html> 
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>  
        <table class="table table-sm">  
            <tr> 
                <th class="text-center"><h5><u><b>SUMMARY OF CURRICULUM VITAE</u></b></h5></th> 
    </tr>
</table>
<h5><b>A. PERSONAL DETAILS</b></h5>
<table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;">  
    <tr> 
        <th style="width:3%">1.</th>
        <th style="width:30%">Name</th>
        <td><?= ucwords(strtolower($biodata->CONm)); ?></td>
    </tr>
    <tr>
        <th>2.</th>
        <th>Department</th>
        <td><?= $biodata->penempatan ? $biodata->penempatan->department->fullname : ' ' ?></td>
    </tr>
    <tr>
        <th>3.</th>
        <th>Faculty</th>
        <td><span style="color: red;">Hold</span></td>
    </tr>
    <tr>
        <th>4.</th>
        <th>Field</th>
        <td><span style="color: red;">Hold</span></td>
    </tr>
    <tr>
        <th>5.</th>
        <th>Qualification</th>
        <td>
            <?php
            $q = $biodata->pendidikanByRank;
            $i = count($q);
            $qualification = '';
            if ($q) {
                foreach ($q as $q) {
                    $qualification .= $q->pendidikanTertinggi ? $q->pendidikanTertinggi->HighestEduLevelBI : '-';
                    $i--;
                    if ($i != 0) {
                        $qualification .= ', ';
                    }
                }
            }
            echo $qualification;
            ?>
        </td>
    </tr>
    <tr>
        <th>6.</th>
        <th>Profesional Organization</th>
        <td><span style="color: red;">Hold</span></td>
    </tr>
    <tr>
        <th rowspan="3">7.</th>
        <th rowspan="3">Scopus <span style="color: red;">*Note: from Publication</span></th> 
    </tr>
    <?php
    $Hindexs = array_filter($biodata->publication, function ($var) {
        return ($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)');
    });
    $Citation = array_filter($biodata->publication, function ($var) {
        return ($var['IndexingDesc'] == 'Indexing (Mycite)');
    });
    ?>

    <tr>
        <td>H-Indeks ( <?= count($Hindexs); ?> ) <span style="color: red;">*Note: High-Indexed (SCOPUS, WOS, ERA)  </span></td> 
    </tr>
    <tr>
        <td>Citation ( <?= count($Citation); ?> ) <span style="color: red;">*Note: Indexing (Mycite)  </span></td> 
    </tr>
    <tr>
        <th rowspan="3">8.</th>
        <th rowspan="3">Google Scholar</th> 
    </tr> 
    <tr>
        <td>H-Indeks ( )</td> 
    </tr>
    <tr>
        <td>Citation ( )</td> 
    </tr>
</table>
<div style="break-after:page"></div>
<h5><b>B. RESEARCH</b></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:3%">1.</th>
            <th style="width:30%">Research Interests <br/><span style="color: red;">(db 6/vw_ResearchInterest)</span></th>
            <td colspan="3"><?= $biodata->researchInterest ? $biodata->researchInterest->Keyword:'-';?></td>
        </tr>
        <?php
        $researchleader = array_filter($biodata->research, function ($var) {
            return ($var['Membership'] == 'Leader');
        });
        $researchleaderCompleted = array_filter($biodata->research, function ($var) {
            return ($var['Membership'] == 'Leader' && $var['ResearchStatus'] == 'Selesai');
        });
        $researchleaderOngoing = array_filter($biodata->research, function ($var) {
            return ($var['Membership'] == 'Leader' && $var['ResearchStatus'] == 'Sedang Berjalan');
        });
        $researchmember = array_filter($biodata->research, function ($var) {
            return ($var['Membership'] == 'Member');
        });
        $researchmemberCompleted = array_filter($biodata->research, function ($var) {
            return ($var['Membership'] == 'Leader' && $var['ResearchStatus'] == 'Selesai');
        });
        $researchmemberOngoing = array_filter($biodata->research, function ($var) {
            return ($var['Membership'] == 'Leader' && $var['ResearchStatus'] == 'Sedang Berjalan');
        });
        ?> 
        <tr> 
            <th rowspan="7">2.</th>
            <th rowspan="7">Research Grants (As Project Leader)</th> 
        </tr>
        <tr>  
            <th>Total No. of Grant</th> 
            <td colspan="2"><?= count($researchleader); ?> <span style="color: red;">*Note: include..Tidak Lengkap,Projek Sakit,Ditangguhkan..etc</span></td>
        </tr>
        <tr>   
            <th>Total Funding (RM ) :</th>
            <td colspan="2"><?= number_format(array_sum(array_column($researchleader, 'Amount')), 2) ?></td>
        </tr> 
        <tr>   
            <th rowspan="2">i)Completed</th>  
            <th>No. of Grant   :</th>
            <td><?= count($researchleaderCompleted); ?></td>
        </tr>
        <tr>    
            <th>Total Funding :</th>
            <td><?= number_format(array_sum(array_column($researchleaderCompleted, 'Amount')), 2) ?></td>
        </tr>
        <tr>   
            <th rowspan="2">ii)	Ongoing</th>  
            <th>No. of Grant   :</th>
            <td><?= count($researchleaderOngoing); ?></td>
        </tr>
        <tr>    
            <th>Total Funding :</th>
            <td><?= number_format(array_sum(array_column($researchleaderOngoing, 'Amount')), 2) ?></td>
        </tr>
        <tr> 
            <th rowspan="7">2.</th>
            <th rowspan="7">Research Grants (As Member)</th> 
        </tr>
        <tr>  
            <th>Total No. of Grant</th> 
            <td colspan="2"><?= count($researchmember) ?> <span style="color: red;">*Note: include..Tidak Lengkap,Projek Sakit,Ditangguhkan..etc</span></td>
        </tr>
        <tr>   
            <th>Total Funding (RM ) :</th>
            <td colspan="2"><?= number_format(array_sum(array_column($researchmember, 'Amount')), 2) ?></td>
        </tr> 
        <tr>   
            <th rowspan="2">i)Completed</th>  
            <th>No. of Grant   :</th>
            <td><?= count($researchmemberCompleted) ?></td>
        </tr>
        <tr>    
            <th>Total Funding :</th>
            <td><?= number_format(array_sum(array_column($researchmemberCompleted, 'Amount')), 2) ?></td>
        </tr>
        <tr>   
            <th rowspan="2">ii)	Ongoing</th>  
            <th>No. of Grant   :</th>
            <td><?= count($researchmemberOngoing) ?></td>
        </tr>
        <tr>    
            <th>Total Funding :</th>
            <td><?= number_format(array_sum(array_column($researchmemberOngoing, 'Amount')), 2) ?></td>
        </tr>
        <tr>    
            <th rowspan="3">3.</th>
            <th rowspan="3">Awards for Research Projects</th>
        </tr>
        <tr>    
            <th class="text-center">International</th>
            <th class="text-center">National</th>
            <th class="text-center">UMS</th>
        </tr>
        <tr>    
            <td><span style="color: red;">Hold</span></td>
            <td><span style="color: red;">Hold</span></td>
            <td><span style="color: red;">Hold</span></td>
        </tr>
        <tr>    
            <th>4.</th>
            <th>International Collaboration</th>
            <td colspan="3"><span style="color: red;">Hold</span></td>
        </tr>


    </table>
</div>
<h5><b>C. TEACHING AND SUPERVISORY</b></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:3%">1.</th>
            <th style="width:35%">Courses Taught</th>
            <td colspan="2"><span style="color: red;">Hold</span></td>
        </tr>
        <?php
        $supervisor = array_filter($biodata->penyeliaan, function ($var) {
            return ($var['LevelPengajian'] == 'M.Phil.' || $var['LevelPengajian'] == 'MASTER' || $var['LevelPengajian'] == 'PHD');
        });

        $chairmainPhdCompleted = array_filter($biodata->penyeliaan, function ($var) {
            return ($var['LevelPengajian'] == 'PHD' && $var['StatusPengajianBM'] == 'TAMAT PENGAJIAN' && $var['TahapPenyeliaanBI'] == 'CHAIRPERSON');
        });

        $chairmainMasterCompleted = array_filter($biodata->penyeliaan, function ($var) {
            return ($var['LevelPengajian'] == 'MASTER' && $var['StatusPengajianBM'] == 'TAMAT PENGAJIAN' && $var['TahapPenyeliaanBI'] == 'CHAIRPERSON');
        });

        $chairmainPhdOngoing = array_filter($biodata->penyeliaan, function ($var) {
            $ongoing = array("DALAM PENGAJIAN", "DALAM PENGAJIAN (LANJUT TEMPOH (I))", "DALAM PENGAJIAN (LANJUT TEMPOH (II))", "DALAM PENGAJIAN (LANJUT TEMPOH (III))", "DALAM PENGAJIAN (LANJUT TEMPOH (IV))", "DALAM PENGAJIAN (LANJUT TEMPOH (V))", "DALAM PENGAJIAN (LANJUT TEMPOH (VI))", "DALAM PENGAJIAN (MENUNGGU VIVA)", "DALAM PENGAJIAN (NOTIS PENGHANTARAN TESIS)", "DALAM PENGAJIAN (PEMBETULAN TESIS)", "DIJANGKA TAMAT");
            return ($var['LevelPengajian'] == 'PHD' && in_array($var['StatusPengajianBM'], $ongoing) && $var['TahapPenyeliaanBI'] == 'CHAIRPERSON');
        });

        $chairmainMasterOngoing = array_filter($biodata->penyeliaan, function ($var) {
            $ongoing = array("DALAM PENGAJIAN", "DALAM PENGAJIAN (LANJUT TEMPOH (I))", "DALAM PENGAJIAN (LANJUT TEMPOH (II))", "DALAM PENGAJIAN (LANJUT TEMPOH (III))", "DALAM PENGAJIAN (LANJUT TEMPOH (IV))", "DALAM PENGAJIAN (LANJUT TEMPOH (V))", "DALAM PENGAJIAN (LANJUT TEMPOH (VI))", "DALAM PENGAJIAN (MENUNGGU VIVA)", "DALAM PENGAJIAN (NOTIS PENGHANTARAN TESIS)", "DALAM PENGAJIAN (PEMBETULAN TESIS)", "DIJANGKA TAMAT");
            return ($var['LevelPengajian'] == 'MASTER' && in_array($var['StatusPengajianBM'], $ongoing) && $var['TahapPenyeliaanBI'] == 'CHAIRPERSON');
        });

        $coSupervisorPhdCompleted = array_filter($biodata->penyeliaan, function ($var) {
            return ($var['LevelPengajian'] == 'PHD' && $var['StatusPengajianBM'] == 'TAMAT PENGAJIAN' && $var['TahapPenyeliaanBI'] == 'CO-SUPERVISOR');
        });

        $coSupervisorMasterCompleted = array_filter($biodata->penyeliaan, function ($var) {
            return ($var['LevelPengajian'] == 'MASTER' && $var['StatusPengajianBM'] == 'TAMAT PENGAJIAN' && $var['TahapPenyeliaanBI'] == 'CO-SUPERVISOR');
        });

        $coSupervisorPhdOngoing = array_filter($biodata->penyeliaan, function ($var) {
            $ongoing = array("DALAM PENGAJIAN", "DALAM PENGAJIAN (LANJUT TEMPOH (I))", "DALAM PENGAJIAN (LANJUT TEMPOH (II))", "DALAM PENGAJIAN (LANJUT TEMPOH (III))", "DALAM PENGAJIAN (LANJUT TEMPOH (IV))", "DALAM PENGAJIAN (LANJUT TEMPOH (V))", "DALAM PENGAJIAN (LANJUT TEMPOH (VI))", "DALAM PENGAJIAN (MENUNGGU VIVA)", "DALAM PENGAJIAN (NOTIS PENGHANTARAN TESIS)", "DALAM PENGAJIAN (PEMBETULAN TESIS)", "DIJANGKA TAMAT");
            return ($var['LevelPengajian'] == 'PHD' && in_array($var['StatusPengajianBM'], $ongoing) && $var['TahapPenyeliaanBI'] == 'CO-SUPERVISOR');
        });

        $coSupervisorMasterOngoing = array_filter($biodata->penyeliaan, function ($var) {
            $ongoing = array("DALAM PENGAJIAN", "DALAM PENGAJIAN (LANJUT TEMPOH (I))", "DALAM PENGAJIAN (LANJUT TEMPOH (II))", "DALAM PENGAJIAN (LANJUT TEMPOH (III))", "DALAM PENGAJIAN (LANJUT TEMPOH (IV))", "DALAM PENGAJIAN (LANJUT TEMPOH (V))", "DALAM PENGAJIAN (LANJUT TEMPOH (VI))", "DALAM PENGAJIAN (MENUNGGU VIVA)", "DALAM PENGAJIAN (NOTIS PENGHANTARAN TESIS)", "DALAM PENGAJIAN (PEMBETULAN TESIS)", "DIJANGKA TAMAT");
            return ($var['LevelPengajian'] == 'MASTER' && in_array($var['StatusPengajianBM'], $ongoing) && $var['TahapPenyeliaanBI'] == 'CO-SUPERVISOR');
        });
        ?> 
        <tr> 
            <th>2.</th>
            <th>Final Year Project Students Supervised</th> 
            <td colspan="2"><?= count($supervisor); ?> <span style="color: red;">*Note: include..M.Phil.,MASTER, & PHD</span></td>
        </tr>
        <tr>  
            <th rowspan="2">3.</th> 
            <th rowspan="2">Single/Chairman Supervisory Committee for PhD Students <span style="color: red;">(Chairperson)</span></th>
            <th>i)Completed:</th>
            <td><?= count($chairmainPhdCompleted); ?> <span style="color: red;">*Note: Tamat Pengajian</span></td>
        </tr>  
        <tr>   
            <th>ii)Ongoing:</th>
            <td><?= count($chairmainPhdOngoing); ?><span style="color: red;">*Note: Dalam Pengajian,Dalam Pengajian (Lanjut Tempoh (I)), Dalam Pengajian (Lanjut Tempoh (Ii)), Dijangka Tamat,..etc</span></td>
        </tr>
        <tr>  
            <th rowspan="2">4.</th> 
            <th rowspan="2">Single/Chairman Supervisory Committee for MSc Students</th>
            <th>i)Completed:</th>
            <td><?= count($chairmainMasterCompleted); ?></td>
        </tr>  
        <tr>   
            <th>ii)Ongoing:</th>
            <td><?= count($chairmainMasterOngoing); ?></td>
        </tr> 
        <tr>  
            <th rowspan="2">5.</th> 
            <th rowspan="2">Co-Supervisory Committee for PhD Students <span style="color: red;">(Co-Supervisor)</span></th> 
            <th>i)Completed:</th>
            <td><?= count($coSupervisorPhdCompleted); ?></td>
        </tr>  
        <tr>   
            <th>ii)Ongoing:</th>
            <td><?= count($coSupervisorPhdOngoing); ?></td>
        </tr> 
        <tr>  
            <th rowspan="2">6.</th> 
            <th rowspan="2">Co-Supervisory Committee for MSc Students</th>  
            <th>i)Completed:</th>
            <td><?= count($coSupervisorMasterCompleted); ?></td>
        </tr>  
        <tr>   
            <th>ii)Ongoing:</th>
            <td><?= count($coSupervisorMasterOngoing); ?></td>
        </tr> 



    </table>
</div>
<h5><b> D. PUBLICATIONS</b></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:3%"> </th>
            <th></th> 
            <th>First / Corresponding Author</th> 
            <th>Co-author <span style="color: red;">(Collaborative Author)</span></th> 
            <th>Total</th> 
            <th>Indexed <span style="color: red;">(High-Indexed (SCOPUS, WOS, ERA)</span></th> 
            <th>Cited <span style="color: red;">(Indexing (Mycite)</span></th> 
            <th>Non-cited <span style="color: red;">(Non-indexed)</span></th> 
            <th>With Impact Factor</th>  
        </tr>
        <?php
        $ArticleFirstAuthor = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Article' && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
        });

        $ArticleCoAuthor = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Collaborative Author');
        });

        $ArticleIndexed = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Article' && $var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)');
        });

        $ArticleCited = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Article' && $var['IndexingDesc'] == 'Indexing (Mycite)');
        });

        $ArticleNonCited = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Article' && $var['IndexingDesc'] == 'Non-indexed');
        });
        ?> 
        <tr> 
            <th>1.</th>
            <th>Journal’s Article <span style="color: red;">(Article)</span></th>
            <td><?= count($ArticleFirstAuthor); ?></td>
            <td><?= count($ArticleCoAuthor); ?></td>
            <td><?= count($ArticleFirstAuthor) + count($ArticleCoAuthor); ?></td>
            <td><?= count($ArticleIndexed); ?></td>
            <td><?= count($ArticleCited); ?></td>
            <td><?= count($ArticleNonCited); ?></td>
            <td><span style="color: red;">Hold</span></td> 
        </tr>
        <?php
        $ReviewFirstAuthor = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Review' && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
        });

        $ReviewCoAuthor = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Review' && $var['KeteranganBI_WriterStatus'] == 'Collaborative Author');
        });

        $ReviewIndexed = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Review' && $var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)');
        });

        $ReviewCited = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Review' && $var['IndexingDesc'] == 'Indexing (Mycite)');
        });

        $ReviewNonCited = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Review' && $var['IndexingDesc'] == 'Non-indexed');
        });
        ?> 
        <tr> 
            <th>2.</th>
            <th>Reviewer <span style="color: red;">(Review)</span></th>
            <td><?= count($ReviewFirstAuthor); ?></td>
            <td><?= count($ReviewCoAuthor); ?></td>
            <td><?= count($ReviewFirstAuthor) + count($ReviewCoAuthor); ?></td>
            <td><?= count($ReviewIndexed); ?></td>
            <td><?= count($ReviewCited); ?></td>
            <td><?= count($ReviewNonCited); ?></td>
            <td><span style="color: red;">Hold</span></td>
        </tr>
        <tr> 
            <th>3.</th>
            <th>Editorial board member/ Panel of reviewer</th>
            <td><span style="color: red;">Hold</span></td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td> 
        </tr>
        <tr>    
            <th rowspan="3">4.</th>
            <th rowspan="3">Abstract in Conferences</th>
        </tr>
        <tr>    
            <th class="text-center" colspan="3">International</th>
            <th class="text-center" colspan="4">National</th> 
        </tr>
        <tr>    
            <td colspan="3"><span style="color: red;">Hold</span></td>
            <td colspan="4"><span style="color: red;">Hold</span></td> 
        </tr>
        <tr> 
            <th>5.</th>
            <th>Patents</th>
            <td colspan="7"><span style="color: red;">Hold</span></td> 
        </tr> 
        <tr> 
            <th>6.</th>
            <th>Book (Monograph)</th>
            <td colspan="7"><span style="color: red;">Hold</span></td> 
        </tr>
        <?php
        $ArticleNewspaper = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Article in Mass Media/Magazine');
        });
        ?>
        <tr> 
            <th>7.</th>
            <th>Article in Newspaper (Invited) <span style="color: red;">(Article in Mass Media/Magazine)</span></th>
            <td colspan="7"><?= count($ArticleNewspaper); ?></td> 
        </tr>
        <?php
        $ChapterBook = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book');
        });
        ?>
        <tr> 
            <th>8.</th>
            <th>Chapter in Book</th>
            <td colspan="7"><?= count($ChapterBook); ?></td> 
        </tr>
        <?php
        $ProceedingAbsFull = array_filter($biodata->publication, function ($var) {
            return ($var['Keterangan_PublicationTypeID'] == 'Proceeding: Abstract' || $var['Keterangan_PublicationTypeID'] == 'Proceeding: Full Paper');
        });
        ?>
        <tr> 
            <th>9.</th>
            <th>Proceeding <span style="color: red;">(Proceeding: Abstract + Proceeding: Full Paper)</span></th>
            <td colspan="7"><?= count($ProceedingAbsFull); ?></td> 
        </tr>


    </table>
</div>

<h5><span style="color: red;"><b> E. AWARDS</b></span></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:3%">No</th>
            <th>AWARDS</th> 
            <th>International</th> 
            <th>National</th> 
            <th>UMS</th> 
            <th>Faculty</th>    
        </tr>
        <tr> 
            <th>1.</th> 
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th> 
        </tr> 
        <tr> 
            <th>2.</th> 
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th> 
        </tr> 

    </table>
</div>

<h5><span style="color: red;"><b> F. LEADERSHIPS AND CONTRIBUTION </b></span></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:4%">1.</th>
            <th style="width:35%">College Master <span style="color: red;">(No Data)</span></th> 
            <td colspan="2"></td>     
        </tr>
        <?php
        $consCoordinator = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Coordinator');
        });
        ?>
        <tr> 
            <th>2.</th> 
            <th>Coordinator <span style="color: red;">*Note: from Consultancy</span></th>
            <td colspan="2"> 
                <?= count($consCoordinator);?>
                <span style="color: red;">*Note: (Key in - Data x Standard)</span>
            </td> 
        </tr> 
        <?php
        $consHead = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Head');
        });
        ?>
        <tr> 
            <th>3.</th> 
            <th>Head <span style="color: red;">*Note: from Consultancy</span></th>
            <td colspan="2"> 
            <?= count($consHead);?>
            <span style="color: red;">*Note: (Key in - Data x Standard)</span>
            </td> 
        </tr> 
        <tr> 
            <th rowspan="2">4.</th> 
            <th>Organizing Conferences/ Symposium <span style="color: red;">(No Data)</span></th>
            <td> </td>
            <td> </td>
        </tr>
        <?php
        $consChairman = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Chairman');
        });
        
        $consSecretary = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Secretary');
        });
        ?>
        <tr>  
            <th>Chairman/ Secretary <span style="color: red;">*Note: from Consultancy</span></th>
            <td style="width:30%"><?= count($consChairman + $consSecretary);?></td> 
            <td> <span style="color: red;">*Note: Chairman + Secretary (Key in - Data x Standard)</span></td>
        </tr>
        <tr> 
            <th>5.</th> 
            <th>Invited Chair session in Conferences/ Symposium <span style="color: red;">(No Data)</span></th>
            <td> </td>
            <td> </td>
        </tr>
        <?php
        $consPlenary = array_filter($biodata->persidangan, function ($var) {
            return ($var['Role'] == 'Peserta');
        });
        
        $consKeynote_Speaker = array_filter($biodata->persidangan, function ($var) {
            return ($var['Role'] == 'Keynote Speaker');
        });
        
        $consPembentang_Jemputan = array_filter($biodata->persidangan, function ($var) {
            return ($var['Role'] == 'Pembentang Jemputan');
        });
        ?>
        <tr> 
            <th>6.</th> 
            <th>Plenary/ Keynote/ Invited Speaker in Conference / Congress / Workshop / Inaugural Lecture <span style="color: red;">*Note: from Conferences</span></th>
            <td><?= count($consPlenary + $consKeynote_Speaker + $consPembentang_Jemputan);?></td>
            <td><span style="color: red;">*Note: (Plenary + Keynote + Invited Speaker Only) </span></td>
        </tr>
        <?php
        $consPanelist = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Panelist');
        });
        ?>
        <tr> 
            <th>7.</th> 
            <th>Invited Talk/Panelist <span style="color: red;">*Note: from Consultancy</span></th>
            <td colspan="2"> <?= count($consPanelist);?> <span style="color: red;">*Note: Panelist Only (Key in - Data x Standard)</span></td> 
        </tr>
        <?php
        $consExternal_Examiner = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'External Examiner');
        });
        ?>
        <tr> 
            <th>8.</th> 
            <th>External Examiner <span style="color: red;">*Note: from Consultancy</span></th>
            <td> <?= count($consExternal_Examiner);?></td>
            <td> <span style="color: red;">*Note: (Key in - Data x Standard)</span></td>
        </tr>
        <?php
        $consInternal_Examiner = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Internal Examiner');
        });
        ?>
        <tr> 
            <th>9.</th> 
            <th>Internal Examiner <span style="color: red;">*Note: from Consultancy</span></th>
            <td> <?= count($consInternal_Examiner);?></td>
            <td> <span style="color: red;">*Note: (Key in - Data x Standard)</span></td>
        </tr>
        <?php
        $consExternal_Assessor = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'External Assessor');
        });
        ?>
        <tr> 
            <th>10.</th> 
            <th>External Assessor / Personal Referee for promotion <span style="color: red;">*Note: from Consultancy</span></th>
            <td colspan="2"><?= count($consExternal_Assessor);?><span style="color: red;">*Note: External Assessor Only (Key in - Data x Standard)</span></td> 
        </tr> 
         <?php
        $consAcademic_Advisor = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Academic Advisor');
        });
        ?>
        <tr> 
            <th>11.</th> 
            <th>Academic Advisor /Examiner for other institutions <span style="color: red;">*Note: from Consultancy</span></th>
            <td colspan="2"><?= count($consAcademic_Advisor);?><span style="color: red;">*Note: Academic Advisor Only (Key in - Data x Standard)</span></td> 
        </tr> 
        <?php
        $consJournal_reviewer = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Journal reviewer');
        });
        
        $consReferee = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peranan'] == 'Referee');
        });
        ?>
        <tr> 
            <th>12.</th> 
            <th>Journal reviewer/referee <span style="color: red;">*Note: from Consultancy</span></th>
            <td colspan="2"> <?= count($consJournal_reviewer + $consReferee);?><span style="color: red;">*Note: Journal reviewer + Referee(Key in - Data x Standard)</span></td> 
        </tr> 

    </table>
</div>

<h5><b>G. CONSULTANCY AND INDUSTRIAL NETWORK</b></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:3%">No</th>
            <th class="text-center">Level</th> 
            <th class="text-center">No. of Consultancy and Industrial Network</th> 
            <th class="text-center">RM</th>  
        </tr>
        <?php
        $outInternational = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peringkat'] == 'International');
        });
        ?>
        <tr> 
            <th>1.</th> 
            <th>International</th>
            <td><?= count($outInternational); ?></td>
            <td><?= number_format(array_sum(array_column($outInternational, 'Jumlah')), 2) ?></td>  
        </tr> 
        <?php
        $outNational = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peringkat'] == 'National');
        });
        ?>
        <tr> 
            <th>2.</th> 
            <th>National</th>
            <td><?= count($outNational); ?></td>
            <td><?= number_format(array_sum(array_column($outNational, 'Jumlah')), 2) ?></td> 
        </tr> 
        <tr> 
            <th>3.</th> 
            <th>Professional Services</th>
            <td><span style="color: red;">Hold</span></td>
            <td> </td>  
        </tr> 
        <?php
        $outOthers = array_filter($biodata->outreaching, function ($var) {
            return ($var['Peringkat'] == 'No Data' || $var['Peringkat'] == 'University');
        });
        ?>
        <tr> 
            <th>4.</th> 
            <th>Others <span style="color: red;">(University + No Data)</span></th>
            <td><?= count($outOthers); ?></td>
            <td><?= number_format(array_sum(array_column($outOthers, 'Jumlah')), 2) ?></td>  
        </tr> 

    </table>
</div>

<h5><b><span style="color: blue;">H. SERVICE TO UNIVERSITIES AND COMMUNITY</span> <span style="color: red;">(REMOVE *Notes: use tbl cv vr3)</span></b></h5> 
<div class="table-responsive">
    <table class="table table-sm table-bordered" style="width:100%;font-size: 12px;font-family:Times New Roman;"> 
        <tr> 
            <th style="width:3%">No</th>
            <th class="text-center">Role</th> 
            <th class="text-center">University </th> 
            <th class="text-center">Community</th>  
        </tr>
        <tr> 
            <th>1.</th> 
            <th>Chairman / Head</th>
            <th> </th>
            <th> </th>  
        </tr> 
        <tr> 
            <th>2.</th> 
            <th>Member</th>
            <th> </th>
            <th> </th> 
        </tr> 
        <tr> 
            <th>3.</th> 
            <th>Speaker</th>
            <th> </th>
            <th> </th>  
        </tr> 
        <tr> 
            <th>4.</th> 
            <th>Participants</th>
            <th> </th>
            <th> </th> 
        </tr> 
        <tr> 
            <th>5.</th> 
            <th>Others</th>
            <th> </th>
            <th> </th> 
        </tr> 

    </table>
</div>

</body>
</html>