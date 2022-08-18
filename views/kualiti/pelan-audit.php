<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\myhealth\TblmaxtuntutanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="kualiti-create">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Pelan Audit</strong></h2>
            <div class="clearfix"></div>
        </div>
        <p>
            <?= Html::a('Tambah Pelan Audit', ['tambah-pelanaudit'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-success']) ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $query,
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                ],
                [
                    'label' => 'ID',
                    'attribute' => 'msiso_id',
                    'format' => 'text',
                ],
                [
                    'label' => 'Kategori',
                    'attribute' => 'kategori',
                    'format' => 'raw',
                ],
                [
                    'label' => 'No Prosedur/Kod Dokumen',
                    'attribute' => 'no_prosedur',
                    'format' => 'raw',
                ],
                [
                    'label' => 'Tajuk Prosedur',
                    'attribute' => 'tajuk_prosedur',
                    'format' => 'text',
                ],
                
                [
                    'label' => 'JAFPIB',
                    'attribute' => 'department.fullname',
                    'format' => 'text',
                ],
                [
                    'label' => 'Kemaskini Akhir',
                    'attribute' => 'update_date',
                    'format' => 'text',
                ],
                [
                    'label' => 'Dokumen',
                    'attribute' => 'file',
                    'format' => 'raw',
                    'value' => function ($query) {
                        return
                            Html::a('', Yii::$app->FileManager->DisplayFile($query->file), ['class' => 'fa fa-download', 'target' => '_blank']);
                    }
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $query) use($access) {

                            if($access){
                            $url = Url::to(['kualiti/view-manual', 'id' => $query->msiso_id]);
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);}else
                            {
                                return '';
                            }
                            }
                    ]
                ]
            ]
        ]);
        ?>
    </div>
</div>
