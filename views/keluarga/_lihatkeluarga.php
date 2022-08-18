<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<?= DetailView::widget([
        
        'model' => $model,
        'attributes' => [
            ['label' => 'Hubungan',
              'value' => $model->hubkeluarga,
              'contentOptions' => ['style' => 'width:auto'],
              'captionOptions' => ['style' => 'width:26%'],
            ],
            ['label' => 'Staf UMS',
              'value' => function($model){
                  if($model->isUms){
                    return "Ya";
                  }
                  return "Tidak";
              }
              ],
            ['label' => 'No. Pengenalan',

              'value' => $model->FamilyId],
            ['label' => 'Jenis Pengenalan',
              'value' =>function($model){
                if($model->idType){
                  return $model->idType->IdType;
                }
                return '-';
              } 
              ],
            ['label' => 'Nama',
              'value' => $model->FmyNm],
            ['label' => 'Gelaran',
              'value' => $model->gel],
            ['label' => 'Jenis Kad Pengenalan',
              'value' => $model->jenIc],
            ['label' => 'No.Pasport ',
              'value' => $model->fmyPassportNo],
            ['label' => 'No. Sijil Lahir',
              'value' => $model->fmyBirthCertNo],
            ['label' => 'Tarikh Lahir',
              'value' => $model->fmyBirthDt],
            ['label' => 'Tempat Lahir',
              'value' => $model->temlahir],
            ['label' => 'Jantina',
              'value' => $model->jan],
            ['label' => 'Agama',
              'value' => $model->aga],
            ['label' => 'Bangsa',
              'value' => $model->bang],
            ['label' => 'Pendidikan Tertinggi',
              'value' => $model->pentertinggi],
            ['label' => 'warganegara',
              'value' => $model->warneg],
            ['label' => 'Nama Ibu',
              'value' => $model->fmyMomNm],
            ['label' => 'Taraf Perkahwinan',
              'value' => $model->staperkahwinan],
            ['label' => 'Status Kembar',
              'value' => $model->twinsta],
            ['label' => 'Status Warganegara',
              'value' => $model->stawarneg],
            ['label' => 'Status Bumiputera',
              'value' => $model->fmybumista],
            ['label' => 'Kecacatan',
              'value' => $model->fmydissta],
            ['label' => 'Status Tanggungan',
              'value' => $model->fmydepsta],
            ['label' => 'Jenis Tanggungan',
              'value' => $model->jentang],
            ['label' => 'Status Pelepasan Cukai',
              'value' => $model->pelcukai],
            ['label' => 'Tarikh Kematian',
              'value' => $model->tarkematian],
            ['label' => 'Tarikh Perkahwinan',
              'value' => $model->tarperkahwinan,],
            ['label' => 'Tarikh Perceraian',
              'value' => $model->fmyDivorceDt,],
            ['label' => 'Status Pekerjaan',
              'value' => $model->stapekahlkel],
            ['label' => 'Nama Majikan',
              'value' => $model->fmyEmployerNm],
            ['label' => 'Jenis Majikan',
              'value' => $model->jenmajikan],
            ['label' => 'Sektor Pekerjaan',
              'value' => $model->sekpekerjaan],
            ['label' => 'Alamat',
              'value' => $model->FmyAddr1],
            ['label' => 'Alamat 2',
              'value' => $model->FmyAddr2,
              'visible'=> $model->FmyAddr2 ? true : false],
            ['label' => 'Alamat 3',
              'value' => $model->FmyAddr3 ,
              'visible'=> $model->FmyAddr3 ? true : false],
            ['label' => 'Poskod',
              'value' => $model->FmyPostcode],
            ['label' => 'Negara',
              'value' => $model->nega],
            ['label' => 'Negeri',
              'value' => $model->nege],
            ['label' => 'Bandar',
              'value' => $model->band],
            ['label' => 'No. Telefon',
              'value' => $model->fmyTelNo],
            ['label' => 'No. Dihubungi jika kecemasan',
              'value' => $model->fmyEmerContactStatus],
            ['label' => 'Email',
              'value' => $model->fmyEmailAddr],
            ['label' => 'Status Pewaris',
              'value' => $model->fmyNextOfKinStatus],
            ['label' => 'Penerima Pencen',
              'value' => $model->fmyPensionRecipient],
            ['label' => 'ID MySejahtera',
              'value' => $model->MySJ_ID],
            ['label' => 'Menghidap Penyakit Kronik',
              'value' => function($model){
                if($model->chronic_disease){
                  return "Ya";
                }
                return "Tidak";
              }],
            ['label' => 'Mempunyai Alahan',
              'value' => function($model){
                if($model->allergic){
                  return "Ya";
                }
                return "Tidak";
              }],
    
        ],
    ]) ?>

<div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content">   
        <div class="x_title">
            <h2><?= "PENYAKIT" ?></h2>
            <div class="clearfix"></div>
        </div> 
            <div class="table-responsive">
            
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="headings">
                            <th>Nama Penyakit</th>
                        </tr>
                    </thead>
                    <?php if (!empty($disease)) {

                        foreach ($disease as $disease) {

                    ?>

                            <tr>
                                <td><?= $disease->description; ?></td>
                            </tr>

                        <?php }
                    } else {
                        ?>
                        <tr>
                            <td colspan="2" class="text-center">Tiada Rekod</td>
                        </tr>
                    <?php
                    } ?>
                </table>
            </div>
        </div>
</div>
</br>

<div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content">   
        <div class="x_title">
            <h2><?= "ALAHAN" ?></h2>
            <div class="clearfix"></div>
        </div> 
            <div class="table-responsive">
            
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="headings">
                            <th>Nama Alahan</th>
                        </tr>
                    </thead>
                    <?php if (!empty($allergic)) {

                        foreach ($allergic as $allergic) {
                    ?>
                            <tr>
                                <td><?= $allergic->description; ?></td>
                            </tr>

                        <?php }
                    } else {
                        ?>
                        <tr>
                            <td colspan="2" class="text-center">Tiada Rekod</td>
                        </tr>
                    <?php
                    } ?>
                </table>
            </div>
        </div>
</div>