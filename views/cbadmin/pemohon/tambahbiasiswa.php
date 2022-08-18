<?php

use yii\helpers\Html;



$this->title = 'Rekod Maklumat Pembiayaan / Pinjaman';
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
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
<div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN BAHARU PENGAJIAN LANJUTAN PENTADBIRAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 "> 

<div class="x_panel">
<div class="x_content">
<div class="tblbiasiswa-create">

    <?= $this->render('_formbiasiswa', [
        'model' => $model, 'iklan' => $iklan,
        'model2' => $model2,
        'modelCustomer' => $modelCustomer,
        'modelsAddress' =>  $modelsAddress]) ?>

</div>
</div>
</div>
</div>


