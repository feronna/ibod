<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\myhealth\TblmaxtuntutanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Enkuiri';
error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="col-md-12 col-xs-12 alert alert-semi-transparent"> 
    <div class="x_panel">
    <div class="x_title">    
        <h3><i class="fa fa-question-circle"></i> Senarai Enkuiri</h3>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title text-center">BIL </th>
                            <th class="column-title text-center">TARIKH ENKUIRI</th>
                            <th class="column-title text-center">NAMA KLINIK</th>
                            <th class="column-title text-center">ENKUIRI</th>
                            <th class="column-title text-center">STATUS</th>
                            <th class="column-title text-center">TINDAKAN</th>
                        </tr>                                             
                    </thead>
                    <tbody>
                        <?php if ($enkuiri) { ?>
                            <?php foreach ($enkuiri as $e) { ?>
                                <tr>
                                    <td class="text-center"><?= $bil++; ?></td>
                                    <td class="text-center"><?= Yii::$app->formatter->asDate($e->entry_dt, 'php:d-m-Y '); ?></td>
                                    <td class="text-center"><?= $e->klinik->nama; ?></td>
                                    <td class="text-center"><?= $e->enquiry; ?></td>
                                    <td class="text-center"><?php echo $e->statusK; ?></td>  
                                    <td class="text-center"> 
                                <?= Html::button('', ['id' => 'modalButton', ''
                                    . 'value' => Url::to(['tindakan', 'id' => $e->id]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit mapBtn']) ?> </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="12" class="align-center text-center"><i>Belum ada enkuiri</i></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>                        
        </div>
    </div>
    </div>
              
                

