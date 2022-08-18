<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Negara;
 
?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Kemudahan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
       

        <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <?=
             GridView::widget([

            'dataProvider' => $dataProvider,
                'options' => [
                'class' => 'table-responsive',
                    ],
            'columns' => [
                ['header' =>'Bil.',
                 'class' => 'kartik\grid\SerialColumn'],
                [
                    'label' => 'Tarikh',
                    'value' => 'rekod.jfpiu',
                ],
                [
                    'label' => 'Tujuan',
                    'value' => 'rekod.nama',
                ],
//                [
//                    'label' => 'Tempat Berkhidmat',
//                //    'value' => 'budget',
//                ],
//                 [
//                    'label' => 'Jumlah',
//                //    'value' => 'budget',
//                ],             
            ],
        ]);
        ?>
            
            
        </div>
    </div>
        </div>
        </div>

    </div>
</div>