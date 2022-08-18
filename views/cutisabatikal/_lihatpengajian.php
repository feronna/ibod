<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("tarikh_mula").value);
                var pickdt = new Date(document.getElementById("tarikh_tamat").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }

        function cal(){
        if(document.getElementById("tarikh_mula")){
            document.getElementById("days").value=GetDays();
        }  
    }

    </script>
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
             'value' => $model->major->MajorMinor],
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

