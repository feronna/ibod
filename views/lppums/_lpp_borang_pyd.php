<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\DetailView;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p align="center"><strong>PERINGATAN</strong></p>
                    <p>Pegawai Penilai (PP) iaitu Pegawai Penilai Pertama (PPP) dan Pegawai Penilai Kedua (PPK) serta Pegawai Yang Dinilai (PYD) hendaklah memberi perhatian kepada perkara-perkara berikut sebelum dan semasa membuat penilaian:</p>
                    <ol type="i">
                        <li>PYD hendaklah menyemak maklumat di <strong>Bahagian I</strong> di bawah dan melengkapkan Bahagian I dalam borang <strong>Sasaran Kerja Tahunan (SKT)</strong> pada awal tahun;</li><br>
                        <li>PYD hendaklah melengkapkan <strong>Bahagian II</strong> manakala PP hendaklah melengkapkan <strong>Bahagian III</strong> hingga <strong>Bahagian IX</strong>;</li><br>
                        <li>PYD hendaklah menyenaraikan tugas-tugas yang dipertanggungjawabkan sepanjang tahun penilaian;</li><br>
                        <li>PYD dan PP hendaklah merujuk Panduan Pelaksanaan Sistem Penilaian Prestasi Pegawai Perkhidmatan Awam Malaysia (Tahun 2002) sekiranya memerlukan keterangan lanjut semasa mengenai Borang Laporan Penilaian Prestasi Tahunan (LNPT) dan membuat penilaian;</li><br>
                        <li>PP hendaklah menggunakan <strong>Skala Penilaian Prestasi</strong>; dan</li><br>
                        <li>PP hendaklah memaklumkan kepada PYD langkah-langkah meningkatkan prestasi/kemajuan kerjaya yang perlu dilakukan sebelum menandatangani di ruang <strong>Bahagian VIII</strong>.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian I - Maklumat Pegawai</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?=
                        DetailView::widget([
                            'model' => $lpp,
                            'attributes' => [
                                [
                                    'label' => 'Nama PYD', 
                                    'value' => function($model) {
                                        return $model->pyd->CONm;
                                    },
                                    'captionOptions' => ['style' => 'width:20%'],
                                ],
                                [
                                    'label' => 'Jawatan / Gred', 
                                    'value' => function($model) {
                                        return $model->gredJawatan->nama.' '.$model->gredJawatan->gred;
                                    },
                                ],
                                [
                                    'label' => 'JAFPIB', 
                                    'value' => function($model) {
                                        return $model->department->fullname;
                                    },
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>