<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

echo $this->render('/idp/_topmenu');

$this->title = $model->tajukLatihan;
//$this->params['breadcrumbs'][] = ['label' => 'Fruits', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">  
        <div class="x_panel">
            <div class="x_title">
                <h2><?= Html::encode($this->title) ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <div class="table-responsive">
                    <?= DetailView::widget([
                            'model' => $model,
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'attributes' => [
                                'tajukLatihan',
                                'penggubalModul',
                                'tahunTawaran',
                                'kategoriJawatanID',
                                'sinopsisKursus',
                                //'klusterKursus.kluster_nama',
//                                [                      // the owner name of the model
//                                    'label' => 'Kluster',
//                                    'value' => $model->klusterKursus->kluster_nama,
//                                    //'contentOptions' => ['class' => 'bg-red'],
//                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
//                                ],
                                [                      // the owner name of the model
                                    'label' => 'Kluster',
                                    'attribute' => 'klusterKursus.kluster_nama',
                                    //'contentOptions' => ['class' => 'bg-red'],
                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
                                ],
                                [                      // the owner name of the model
                                    'label' => 'Kompetensi',
                                    'attribute' => 'kompetensiii.kategori_nama',
                                    //'contentOptions' => ['class' => 'bg-red'],
                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
                                ],
                                //'campusName.campus_name',
//                                [                      // the owner name of the model
//                                    'label' => 'Kampus',
//                                    'value' => $model->campusName->campus_name,
//                                    //'contentOptions' => ['class' => 'bg-red'],
//                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
//                                ],
//                                [                      // the owner name of the model
//                                    'label' => 'Kampus',
//                                    'attribute' => 'campusName.campus_name',
//                                    //'contentOptions' => ['class' => 'bg-red'],
//                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
//                                ],
                                //'penceramah.CONm',
                                //'penceramahID:html',
//                                [                      // the owner name of the model
//                                    'format' => 'raw',
//                                    'label' => 'Penceramah',
//                                    //'value' => ucwords(strtolower($model->penceramah->displayGelaran.' '.$model->penceramah->CONm)),
//                                    'value' => ucwords(strtolower($model->penceramah->displayGelaran.' '.$model->penceramah->CONm)),
//                                    //'contentOptions' => ['class' => 'bg-red'],
//                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
//                                ],
                            ],
                        ]) ?>
                    </div>    
                </div> <!-- ubah sini -->
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">  
                        <?= Html::a('Kemaskini', ['update-latihan', 'id' => $model->kursusLatihanID], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Hapus', ['delete-latihan', 'id' => $model->kursusLatihanID], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Adakah anda pasti anda ingin menghapuskan kursus ini?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div> <!-- x_content -->
        </div>
    </div>
</div>