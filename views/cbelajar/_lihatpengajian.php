<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'LOKASI PENGAJIAN',
             'value'=>$model->lokasi
        ],
            ['label'=>'NAMA UNIVERSITI',
             'value'=>$model->InstNm],
            ['label'=> 'NEGARA',
//             'value' => $model->negara->Country,
                 'value'=>function ($model)  {
                        if($model->Country)
                        {
                          return strtoupper($model->negara->Country);  
                        }
                        else {
                                        return 'TIADA MAKLUMAT';
                        }
                        },
             'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label'=> 'PERINGKAT PENGAJIAN',
             'format'=>'raw',
             'value' =>$model->tahapPendidikan],
            ['label'=> 'BIDANG PENGAJIAN',
//             'value' => strtoupper($model->major->MajorMinor)],
            
              'value'=>function ($model)  {
                        if($model->MajorCd == 9999)
                        {
                          return strtoupper($model->MajorMinor);  
                        }
                        else {
                                    return strtoupper($model->major->MajorMinor);
                        }
                        },
                                ],
             ['label'=> 'MOD PENGAJIAN',
             'format'=>'raw',
             'value' =>$model->mod->studyMode],
            ['label'=> 'TARIKH MULA PENGAJIAN',
             'value' => $model->tarikhmula],
            ['label'=> 'TARIKH TAMAT PENGAJIAN',
             'value' => $model->tarikhtamat],
            ['label'=> 'TEMPOH PENGAJIAN',
             'value' => $model->tempohtajaan],
            ['label'=> 'TAJUK TESIS/TAJUK PENYELIDIKAN',
             'value' => $model->tajuk_tesis],
            ['label'=> 'NAMA PENYELIA',
             'value' => $model->nama_penyelia],
            ['label'=> 'EMEL PENYELIA',
             'value' => $model->emel_penyelia],
            

        ],
    ]) ?>

