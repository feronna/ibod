<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-plus"></i><strong> Tambah Klinik</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KLINIK<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'klinik_nama')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ALAMAT<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'klinik_alamat')->textarea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO. TELEFON<span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($klinik, 'klinik_no_tel')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
                   

            </div>
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end();?>
     </div>
    </div>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-pencil-square-o"></i><strong> Selenggara Klinik</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">NAMA KLINIK</th>
                        <th class="column-title text-center">ALAMAT KLINIK</th>
                        <th class="column-title text-center">NO TELEFON</th>
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
//                    if($query){
                    foreach ($query as $admins) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $admins->klinik_nama; ?></td>
                            <td><?= $admins->klinik_alamat; ?></td>
                            <td><?= $admins->klinik_no_tel; ?></td>
                            <td>
                                
                                
        <?= Html::a('<i class="fa fa-pencil"></i>', ['updatek', 'id' => $admins->klinik_gigi_id], [  
        ])  ?> 
        |
        <?= Html::a('<i class="fa fa-trash-o"></i>', ['deleted', 'id' => $admins->klinik_gigi_id], [
            'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',   
        ],
        ])  ?>
    </td>
    
                    <?php 
                    
                    }
                    
                     ?>
                </tbody>
            </table>
            </div>
                
        </div>
    </div>
</div>


