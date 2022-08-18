<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Biodata';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblprcobiodata-view ">
                <p>
                    <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kemaskini', ['kemaskinikakitangan-kprogram', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
                </p>
                <div class="table-responsive">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ICNO',
            ['label'=> 'UMSPER',
             'value' => $model->COOldID,
             'contentOptions' => ['style'=>'width:auto'],
             'captionOptions' => ['style'=>'width:26%'],],
            ['label'=> 'Gelaran',
             'value' => $model->displayGelaran],
            ['label'=> 'Nama',
             'value' => $model->CONm],
            ['label'=> 'Agama',
             'value' => $model->displayAgama],
            ['label'=> 'Bangsa',
             'value' => $model->displayBangsa],
            ['label'=> 'Etnik',
             'value' => $model->displayEtnik],
            ['label'=> 'Status Uniform',
             'value' => $model->displayStatusUniform],
            ['label'=> 'Jenis Darah',
             'value' => $model->displayJenisDarah],
            ['label'=> 'Taraf Perkahwinan',
             'value' => $model->displayTarafPerkahwinan],
            ['label'=> 'Pendidian Tertinggi',
             'value' => $model->displayPendidikan],
            ['label'=> 'Jantina',
             'value' =>$model->displayJantina],
            ['label'=> 'Negara Lahir',
             'value' => $model->displayNegaraLahir],
            ['label'=> 'Tempat Lahir',
             'value' => $model->displayTempatLahir],
            ['label'=> 'Negara Asal Staf',
             'value' => $model->displayNegaraAsalStaf],
            ['label'=> 'Negeri Asal Staf',
             'value' => $model->displayNegeriAsalStaf ],
             ['label'=> 'Negeri Asal Ibu',
             'value' => $model->negeriAsalIbu],
             ['label'=> 'Negeri Asal Bapa',
             'value' => $model->negeriAsalBapa],
            ['label'=> 'Warganegara',
             'value' => $model->displayWarganegara],
            ['label'=> 'Status Warganegara',
             'value' => $model->displayStatusWarganegara],
            ['label'=> 'Status Bumiputera',
             'value' => $model->displayStatusBumiputera],
             ['label'=> 'Status Sabahan',
             'value' => function($model){
                 if($model->isSabahan == '1'){
                     return 'Sabahan';
                 }elseif($model->isSabahan == '0'){
                    return 'Bukan Sabahan'; 
                 }
                 return ' ';                 
             }],
            ['label'=> 'E-mel',
             'value' => $model->COEmail],
            ['label'=> 'E-mel 2',
             'value' => $model->COEmail2,
             'visible' => function($model){
                 return !empty($model->COEmail2);
             }
            ],
            ['label'=> 'No. Sijil Lahir',
             'value' => $model->COBirthCertNo],
            ['label'=> 'Tarikh Lahir',
             'value' => $model->displayBirthDt],
            ['label'=> 'No. Telefon Bimbit',
             'value' => $model->COHPhoneNo],
            ['label'=> 'No. Telefon Bimbit 2',
             'value' => $model->displayPhone2],
            /*['label'=> 'Status Telefon Bimbit',
             'value' => $model->displayStatusPhone],*/
            ['label'=> 'No. Telefon Pejabat',
             'value' => $model->COOffTelNo],
            ['label'=> 'No. Sambungan 1',
             'value' => $model->COOffTelNoExtn],
            ['label'=> 'No. Sambungan 2',
             'value' => $model->COOffTelNoExtn2,
             'visible' => $model->COOffTelNoExtn2 ? true : false],
            ['label'=> 'No. UC',
             'value' => $model->COOUCTelNo,],
            [
                'label' => 'ID MySejahtera',
                'value' => $model->mySejahteraId,
            ],

            
            ['label' => 'Kod Program',
            'value' => $model->KodProgram ? $model->programPengajaran->KodProgram. '( '. $model->programPengajaran->NamaProgram.' )' : 'Tidak Berkaitan'],
            ['label' => 'Jawatan Pentadbiran',
             'value' => $model->displayJawatanPentadbiran],
            ['label' => 'Gred Jawatan Hakiki',
             'value' => $model->displayJawatanHakiki],
            ['label' => 'Jabatan Hakiki',
             'value' => $model->displayDepartmentHakiki],
            ['label' => 'Kampus Hakiki',
             'value' => $model->displayKampusHakiki],
        ],
    ]) ?>
               </div>

            </div>   
        </div>
    </div>
</div>

