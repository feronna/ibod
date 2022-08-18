<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;use app\widgets\TopMenuWidget;

$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?><?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        if ($model) {
            return ['class' => 'info'];
        }
    },
    /*   'filterModel' => $searchModel, */ //to hide the search row
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Nama Pemohon',
            'value' => 'kakitangan.CONm',
        ],
       
      [
            'label' => 'J/F/P/I/U',
            'value' => 'dept.shortname',
        ],
        
       
    ],
]);
?>
