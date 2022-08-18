<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('/openpos/_menu'); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

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
            'label' => 'View',
            'format' => 'raw',
            'value' => function ($data) {
                return  Html::a('<i class="fa fa-eye">', ["openpos/s_tindakan_permohonan", 'ids' => $data->icno]);
               // return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['tindakan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-eye mapBtn']);
            },
        ],
       
    ],
]);
?>
