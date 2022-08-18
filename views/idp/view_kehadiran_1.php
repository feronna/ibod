<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */
echo $this->render('/idp/_topmenu');  
echo \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]);
// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group'=>true,
        'label'=>'BAHAGIAN 1: Informasi Kursus Latihan',
        'rowOptions'=>['class'=>'table-info']
    ],
    [
        'columns' => [
            [
                'attribute'=>'kursusLatihanID', 
                'label'=>'Kursus Latihan #',
                'format'=>'raw', 
                'value'=>'<kbd>'.$model->kursusLatihanID.'</kbd>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'tajukLatihan',
                'value'=> ucwords(strtolower($model->tajukLatihan)),
                'displayOnly'=>true,
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [ 
            [
                'attribute'=>'penggubalModul', 
                'label'=>'Pemilik Modul',
                'format'=>'raw', 
                'value'=>$model->penggubalModul,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'label'=>'Tahun Tawaran', 
                'format'=>'raw',
                'value'=>'<span class="text-justify">' . $model->tahunTawaran  . '</span>',
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
    [
        'columns' => [ 
            [   
                'label' => 'Penceramah',
                'format'=>'raw',
                'value'=>Html::a(ucwords(strtolower($model->penceramah->displayGelaran . ' ' . $model->penceramah->CONm)), '#', ['class'=>'kv-author-link']),
//                'type'=>DetailView::INPUT_SELECT2, 
//                'widgetOptions'=>[
//                    'data'=>ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy('CONm')->asArray()->all(), 'ICNO', 'CONm'),
//                    'options' => ['placeholder' => 'Sila Pilih ...'],
//                    'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
//                ],
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'label'=>'Kategori Jawatan', 
                'format'=>'raw',
                'value'=>'<span class="text-justify">' . $model->kategoriJawatanID  . '</span>',
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label'=>'Sinopsis Kursus',
                'format'=>'raw',
                'value'=>'<span class="text-justify"><em>' . $model->sinopsisKursus  . '</em></span>',
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
            ],
        ],
    ],
    [
        'columns' => [
            [   
                'label' => 'Bahan Kursus',
                'format' => 'raw',
                'value' => $model->sasaran10->filename,
//                'value' => function ($model){
//                            $datalist = [];
//                            if ($model->sasaran10){
//                                foreach ($model->sasaran10 as $files) {
//                                    $a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
//                                    array_push($datalist, $a); 
//                                }
//                            } else {
//                                return "TIADA BAHAN";
//                            }
//                            $all = " ";
//                            $b = count($datalist);
//                            for($i = 0; $i < count($datalist); $i++){
//                                $all = $b.') '.$datalist[$i].$all;
//                                $b--;
//                            }
//                            return $all;
//                },
            ],
        ],
    ],
    
];


?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-info-circle"></i> Maklumat Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
            <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                    'mode' => 'view',
                    'bordered' => true,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'fadeDelay' => 1,
//                    'panel' => [
//                        'type' => 'info', 
//                        'heading' => 'Butir-Butir Latihan',
//                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
//                    ],
                    'buttons1' => false,
                    'deleteOptions'=>[ // your ajax delete parameters
                        'params' => ['id' => $model->kursusLatihanID, 'kvdelete'=>true],
                    ],
                    'container' => ['id'=>'kv-demo'],
                    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
                ]);
                
            ?>
        </div>
    </div>
</div>

