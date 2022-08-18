<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'Nama Tajaan',
             'value'=>$model->nama_tajaan],
            
           
            ['label'=> 'Bentuk Tajaan',
             'value' => $model->bantuan->bentukBantuan,
            ],
            ['label'=> 'Amaun',
             'format'=>'raw',
             'value' => "RM". " ". $model->amaunBantuan],
           
            

        ],
    ]) ?>

