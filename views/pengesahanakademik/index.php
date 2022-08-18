<?php
use yii\helpers\Html;
error_reporting(0);
?>
<?= $this->render('/pengesahan/_topmenu') ?>
<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
    <div class="x_content">  
        <strong>
            Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
            <table>
                <tr>
                    <td>
                        Pn Rozaidah Amir Hussein<br/>
                        Penolong Pendaftar Kanan <br/>
                        Tel: 088320000 (samb. 102005)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        Pn Patricia Binti Joseph<br/>
                        Pembantu Tadbir <br/>
                        Tel: 088320000 (samb. 102241)
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </strong>  
    </div>
    </div>
    
    <div class="x_panel">  
        <div class="x_title">
            <h2><strong>Status Permohonan Pengesahan Dalam Perkhidmatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL.</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">STATUS</th>
                       
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
            </table>
            <ul>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>
</div>


