<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['biodata/index']) ?></li>
        <li>Tambah Kakitangan</li>
    </ol>
</div>
    <div class="x_panel">
        <div class="x_content">
            <div class="tblprcobiodata-view">
                
<div class="x_panel">
        <div class="x_title">
            <h2>Maklumat Rekod Kakitangan</h2>
            <div class="clearfix"></div>
        </div>
<div class="x_content"> 
    
    <ul>
        <li><?= Html::encode($model1->ICNO) ?></li>
    </ul>
    
    
</div>
    <div class=" text-center">
        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
    </div>
</div>

            
<div class="x_panel">
        <div class="x_title">
            <h2>Program Pengajaran: Kakitangan Akademik Sahaja</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
        <?php //DetailView::widget([
//            'model' => $model,
//            'attributes' => [
//       
//                 ['label' => 'Program Pengajaran',
//                 'value' => function($model){
//                     return $model->displayProgramPengajaran;
//                 }],
//        
//
//             ],
        // ]) ?>
       </div>
    <div class=" text-center">
        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
    </div>
</div>
            
<div class="x_panel">
        <div class="x_title">
            <h2>Maklumat Rekod Perkhidmatan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
       
            <?php 




$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left'], 'action' => 'confirmtosave']);

?>
        <?= $form->field($model1, 'ICNO')->textInput(['style' => 'border: none;border-color: transparent;'])->label(false) ?>
        <?= $form->field($model1, 'COOldID')->textInput(['disabled' => 'disabled'])->label(false) ?>
            
        <div class="form-group text-center">
            <?= Html::a('Kembali', ['tambahkakitangan'],  ['class' => 'btn btn-primary']) ?>
            <?php echo Html::submitButton('Simpan', ['class'=>'btn btn-primary']) ?>
        </div>
        
<?php ActiveForm::end(); ?>
            
        </div>

    </div>


