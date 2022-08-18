<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$statusLabel = [
    '1' => 'Monthly',
    '2' => 'Part-time/Claims-based Salary',
    '3' => 'Bonus/Cash Assist (Separate)',
    '4' => 'BOD'
];
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-money"></i> Maklumat Profil Gaji</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            
            <?php if(!$staff_salary->isNewRecord) 
            {
            ?>
            <?= Html::a('Kembali', ['view-utama','id'=>$ICNO], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Kemaskini', ['tkpg','ICNO'=>$ICNO,'id'=>$ID], ['class' => 'btn btn-primary']) ?> 
                <div class="table-responsive">
                    <?= DetailView::widget([
                        'model' => $staff_salary,
                        'attributes' => [

                            [
                                'label' => 'Tarikh Mula',
                                'value' =>  strtoupper($staff_salary->tarikhMula),
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'Tarikh Akhir',
                                'value' => strtoupper($staff_salary->tarikhTamat)
                            ],
                            [
                                'label' => 'Jenis Gaji',
                                'value' =>  strtoupper($statusLabel[$staff_salary->SS_SALARY_TYPE])
                            ],
                            [
                                'label' => 'Status Gaji',
                                'value' => function ($data) {
                                    if ($data->SS_SALARY_STATUS == 'Y') {
                                        return '<span class="label label-success">&#10004</span>';
                                    }
                                    if ($data->SS_SALARY_STATUS == 'N') {
                                        return '<span class="label label-danger">&#10006</span>';
                                    }
                                },

                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Kadar Harian/Jam',
                                'value' =>  $staff_salary->SS_RATE
                            ],
                            [
                                'label' => 'Cukai',
                                'value' => function ($data) {
                                    if ($data->SS_EPF_STATUS == 'Y') {
                                        return '<span class="label label-success">&#10004</span>';
                                    }
                                    if ($data->SS_EPF_STATUS == 'N') {
                                        return '<span class="label label-danger">&#10006</span>';
                                    }
                                },

                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Kategori Cukai',
                                'value' => strtoupper($staff_salary->kategoriCukai ? $staff_salary->kategoriCukai->TC_CATEGORY_DESC : '-')
                            ],
                            [
                                'label' => 'Formula Cukai',
                                'value' => strtoupper($staff_salary->formulaCukai ? $staff_salary->formulaCukai->TFT_DESC : '-')
                            ],
                            [
                                'label' => 'Cukai Bayar Zakat?',
                                'value' => function ($data) {
                                    if ($data->SS_ZAKAT_STATUS == 'Y') {
                                        return '<span class="label label-success">&#10004</span>';
                                    }
                                    if ($data->SS_ZAKAT_STATUS == 'N') {
                                        return '<span class="label label-danger">&#10006</span>';
                                    }
                                },

                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Zakat Bayar Kepada',
                                'value' => strtoupper($staff_salary->SS_ZAKAT_CODE)
                            ],
                            [
                                'label' => 'KWSP',
                                'value' => function ($data) {
                                    if ($data->SS_TAX_STATUS == 'Y') {
                                        return '<span class="label label-success">&#10004</span>';
                                    }
                                    if ($data->SS_TAX_STATUS == 'N') {
                                        return '<span class="label label-danger">&#10006</span>';
                                    }
                                },

                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Jenis KWSP',
                                'value' => strtoupper($staff_salary->jenisKwsp ? $staff_salary->jenisKwsp->ET_DESC : '-')
                            ],
                            [
                                'label' => 'Kaedah Kiraan',
                                'value' => strtoupper($staff_salary->SS_EPF_METHOD)
                            ],
                            [
                                'label' => 'Pekerja %',
                                'value' => strtoupper($staff_salary->SS_EPF_EMPYEE_PCT)
                            ],
                            [
                                'label' => 'Majikan %',
                                'value' => strtoupper($staff_salary->SS_EPF_EMPYER_PCT)
                            ],
                            [
                                'label' => 'PERKESO?',
                                'value' => function ($data) {
                                    if ($data->SS_SOCSO_STATUS == 'Y') {
                                        return '<span class="label label-success">&#10004</span>';
                                    }
                                    if ($data->SS_SOCSO_STATUS == 'N') {
                                        return '<span class="label label-danger">&#10006</span>';
                                    }
                                },

                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Jenis PERKESO',
                                'value' => strtoupper($staff_salary->jenisPerkeso ? $staff_salary->jenisPerkeso->ST_DESC : '-')
                            ],
                            [
                                'label' => 'Pencen?',
                                'value' => function ($data) {
                                    if ($data->SS_PENSION_STATUS == 'Y') {
                                        return '<span class="label label-success">&#10004</span>';
                                    }
                                    if ($data->SS_PENSION_STATUS == 'N') {
                                        return '<span class="label label-danger">&#10006</span>';
                                    }
                                },

                                'format' => 'raw',
                            ],
                            [
                                'label' => 'Sebab Perubahan',
                                'value' => strtoupper($staff_salary->SS_CHANGE_REASON)
                            ],

                        ],
                    ]) ?>
                </div>
            <?php
            }else{
            ?>
                <?= Html::a('Kembali', ['view-utama','id'=>$ICNO], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Tambah', ['tkpg','ICNO'=>$ICNO], ['class' => 'btn btn-primary']) ?>
                <p class="text-center">Tidak ada data.</p>
            <?php
            }
            ?>


            </div>
        </div>
    </div>
</div>