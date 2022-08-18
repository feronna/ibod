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
                            'attributes' => [
                                'tajukLatihan',
                                'penggubalModul',
                                'tahunTawaran',
                                'kategoriJawatanID',
                                //'klusterKursus.kluster_nama',
                                [                      // the owner name of the model
                                    'label' => 'Kluster',
                                    'value' => $model->klusterKursus->kluster_nama,
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
                                //'penceramah.CONm',
                                //'penceramahID:html',
                                [                      // the owner name of the model
                                    'format' => 'raw',
                                    'label' => 'Penceramah',
                                    //'value' => ucwords(strtolower($model->penceramah->displayGelaran.' '.$model->penceramah->CONm)),
                                    'value' => ucwords(strtolower($model->penceramah->displayGelaran.' '.$model->penceramah->CONm)),
                                    //'contentOptions' => ['class' => 'bg-red'],
                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
                                ],
                                [   
                                    'label' => 'Sinopsis',
                                    //'value' => ucwords(strtolower($model->penceramah->displayGelaran.' '.$model->penceramah->CONm)),
                                    'value' => $model->sinopsisKursus,
                                    //'contentOptions' => ['class' => 'bg-red'],
                                    //'captionOptions' => ['tooltip' => 'Tooltip'],
                                ],
                                [                      // the owner name of the model
                                    'format' => 'raw',
                                    'label' => 'Bahan Kursus',
                                    //'value' => ucwords(strtolower($model->penceramah->displayGelaran.' '.$model->penceramah->CONm)),
                                    'value' => function ($model){
                                                    $datalist = [];
                                                    if ($model->sasaran10){
                                                        foreach ($model->sasaran10 as $files) {
                                                            $a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                                                            array_push($datalist, $a); 
                                                        }
                                                    } else {
                                                        return "TIADA BAHAN";
                                                    }
                                                    $all = " ";
                                                    $b = count($datalist);
                                                    for($i = 0; $i < count($datalist); $i++){
                                                        $all = $b.') '.$datalist[$i].$all;
                                                        $b--;
                                                    }
                                                    return $all;
                                                },
                                ],
                            ],
                        ]) ?>
                    </div>    
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
    </div>
</div>