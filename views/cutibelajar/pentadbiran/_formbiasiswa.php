<?php
use yii\helpers\Url;    
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\TblTajaan; 
use app\models\cbelajar\TblBantuan;
use yii\bootstrap\Dropdown;
use app\models\cbelajar\RefBantuan;
$title = $this->title = 'Pembiayaan / Pinjaman';

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
error_reporting(0);
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
    <p align ="right">
               
                <?php echo Html::a('Kembali',['pengakuan-pemohon', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
            </p>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN SIJIL / DIPLOMA /  SARJANA MUDA / SARJANA / PHD
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>


<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 

 <div class="x_panel">
 <div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12">JENIS TAJAAN :<span class="required"></span>
</label>
  <div class="col-md-6 col-sm-6 col-xs-12">
        <?php
        echo Html::beginTag('div', ['class'=>'dropdown']);
        echo Html::button('&nbsp Pilih Tajaan &nbsp &nbsp <span class="caret"  ></span>', 
            ['type'=>'button', 'class'=>'btn btn-default', 'data-toggle'=>'dropdown']);
        echo Dropdown::widget([
            'items' => [
                ['label' => 'Tajaan Luar', 'url' =>  ['tajaanluar', 'id'=> $iklan->id]],

                ['label' => 'Biasiswa Pengurusan UMS', 'url' =>  ['biasiswaums', 'id'=>$iklan->id]],
                ['label' => 'Tanpa Tajaan', 'url' =>  ['tanpatajaan', 'id'=> $iklan->id]],

            ],
        ]); 
        echo Html::endTag('div');
        ?> 
</div> 
 </div>
 </div></div>
<!-- Maklumat Pembiayaan / Pinjaman -->



           

    
   


         
                 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

        <?php ActiveForm::end(); ?>











          

   



