<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'Nama Universiti',
             'value'=>$model->InstNm],
            ['label'=> 'Negara',
             'value' => $model->negara->Country,
             'contentOptions' => ['style'=>'width:auto'],
              'captionOptions' => ['style'=>'width:26%'],
            ],
            ['label'=> 'Bidang Pengajian / Latihan',
             'value' => $model->major],
             ['label'=> 'Mod Pengajian',
             'format'=>'raw',
             'value' =>$model->mod->studyMode],
            ['label'=> 'Tarikh Mula Pengajian',
             'value' => $model->tarikhmula],
            ['label'=> 'Tarikh Tamat Pengajian',
             'value' => $model->tarikhtamat],
//            ['label'=> 'Tempoh Pengajian',
//             'value' => $model->tempohpengajian],
           
            

        ],
    ]) ?>

