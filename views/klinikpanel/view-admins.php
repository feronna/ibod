<?php

use yii\helpers\Html;

$this->title = 'Butiran Rawatan';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <p>
                    <?= Html::a('Kembali',['views','batch_id'=> $model->tblvisit_batch_id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a('Padam', ['deleted', 'id' => $model->rawatan_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                </p>
                
                <?=
                $this->render('display', [
                    'model' => $model,
                    'namaubat' => $namaubat,
                    'jumlah' => $jumlah,   
                    
                ])
                ?>

            </div>   
        </div>
    </div>

