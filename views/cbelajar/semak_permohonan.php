<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Pengajian Lanjutan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">MESYUARAT</th>
                        <th class="column-title text-center">KATEGORI</th>
                        <th class="column-title text-center">TARIKH MESYUARAT</th>
                        <th class="column-title text-center">TARIKH MOHON</th>
                        <th class="column-title text-center">STATUS</th>
                       
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
                
            </table>
            <br/>
            <br/>
            <ul>
                <li><span class="label label-warning">Dalam Tindakan KP</span> : Menunggu persetujuan dari Ketua Pentadbiran</li>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>


