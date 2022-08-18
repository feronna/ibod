<?php

use yii\helpers\Html;
error_reporting(0);?>
<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>

<?= $this->render('/kontrak/_topmenu') ?>

<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>
        1. Sila berhubung dengan Puan NORFIRDAYU BINTI IBRAHIM (Tel: 088-320000 Samb. 1523) sekiranya ada sebarang pertanyaan.
        
    </p>
</marquee>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
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
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">STATUS</th>
                       
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
            </table>
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


