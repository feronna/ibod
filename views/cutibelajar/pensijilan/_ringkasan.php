<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

error_reporting(0);
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
$title = $this->title = 'Ringkasan Penyelidikan';
?>




<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>



<div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
   <!--     <strong><p><i>Sila lengkapkan Borang Kementerian Pendidikan Malaysia (KPM) dan muatnaik dokumen tersebut di bahagian menu "Muat Naik Dokumen"</i></p></strong><br>-->
        <div class="table-responsive">

            <table class="table table-sm jambo_table table-striped">
                <th scope="col" colspan="6" width="30%" style="background-color:lightblue;"><center><?= $research->Title; ?></center></th>
                
                <tr>
                <th>Head-researchers <br/>(CO-researchers)</th> 

                <td><?= $research->Researchers ? ucwords(strtolower($research->Researchers)) : '-'; ?></td>
                </tr>
                <tr>
                <th style="width: 10%;">Date</th> 

                <td><?= $research->StartDate ? $research->StartDate : '-'; ?> - <?= $research->EndDate ? $research->EndDate : '-'; ?></td>
                </tr>
                <tr>
                <th>Status</th> 

                <td><?= $research->ResearchStatus ? $research->ResearchStatus : '-'; ?></td>
                </tr>
                <tr>
                <th>Source of Funds (Agency Name)</th> 

                <td><?= $research->AgencyName ? $research->AgencyName : '-'; ?></td>
                </tr>
                <tr>
                <th>Amount</th> 

                <td><?= $research->Amount ? '(RM' . number_format($research->Amount, 2) . ')' : ' '; ?></td>
                </tr>
            </table>
        </div>



    </div>

</div>

<?php ActiveForm::end(); ?>
  




