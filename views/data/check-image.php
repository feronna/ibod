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


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
                ['class' => 'kartik\grid\SerialColumn',
                ],
                [
                    'label' => 'No.KP Kakitangan',
                'attribute' => 'ICNO',
                'format' => 'text',
                ],
                [
                'label' => 'UMSPER',
                'attribute' => 'COOldID',
                'format' => 'text',
                ],
                ['label' => 'Nama Kakitangan',
                'value' => 'CONm',
                'format' => 'text',
                ],
                ['label' => 'Gred Jawatan',
                'value' => 'jawatan.fname',
                'format' => 'text',
                ],
                ['label' => 'JAFPIB',
                'value' => 'department.fullname',
                'format' => 'text',
                ],
                ['label' => 'Status Gambar',
                'value' => 'pic.statusgambar',
                'format' => 'raw',
                ],
               
                ['class' => 'kartik\grid\ActionColumn',
                
    ]]]);
    ?>
</div>