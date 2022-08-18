<?php

use yii\helpers\Html;

$this->title = 'Butiran Rawatan';
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="tblmaxtuntutan-search"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <p>
                    <?= Html::a('<i class="fa fa-sign-out" aria-hidden="true"></i> Kembali',['rekod-lawatan'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i> Kemaskini',['updater','id' => $model->rawatan_id], ['class' => 'btn btn-success']) ?>
                    <?=
                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Padam', ['deleted', 'id' => $model->rawatan_id], [
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

