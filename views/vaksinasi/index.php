<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Tblpengalamankerjas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblpengalamankerja-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <p>
        <?= Html::a('Create Tblpengalamankerja', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                      
                'label' => 'IC / Passport No',
                'value' => $model->icno,
            ],            
            'mysj_id:html',    
            [                      
                'label' => 'Sudah Berdaftar',
                'value' => function($model){
                    if($model->daftar == '1'){
                        return 'YA';
                    }
                    return 'TIDAK';
                },
            ],
            [                     
                'label' => 'Sebab Tidak Berdaftar',
                'value' => function($model){
                    if($model->daftar == '1'){
                        return 'YA';
                    }
                    return 'TIDAK';
                },
                'visible' => function($model){
                    if($model->daftar == '1'){
                        return false;
                    }
                    return true;
                },
            ],
            // 'created_at:datetime', // creation date formatted as datetime
        ],
    ]); ?>
</div>