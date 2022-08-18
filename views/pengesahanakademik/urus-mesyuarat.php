<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
?>
<?= $this->render('/pengesahan/_topmenu') ?>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Urus Mesyuarat</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
          <div class="table-responsive">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
          <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Mesyuarat Kali Ke-<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'kali_ke')->textInput(['maxlength' => true, 'rows' => 4])->label(false);
                        ?>
                    </div>
          </div> 
         <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= DatePicker::widget([
                            'name' => 'tarikh_mesyuarat',
                            'value' => date('d-M-Y'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy'
                            ]
                        ]);?>
                    </div>
                </div>
         <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa Mesyuarat<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= TimePicker::widget([
                        'name' => 'masa_mesyuarat',
                        'size' => 'sm',
                        'containerOptions' => ['class' => 'has-success']
                        ]);
                        ?>
                    </div>
          </div>
        
         <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Mesyuarat<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'nama_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
         <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempat Mesyuarat<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($urus, 'tempat_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Mesyuarat</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil.</th>
                        <th class="column-title text-center">Mesyuarat kali ke</th>
                        <th class="column-title text-center">Tarikh Mesyuarat</th>
                        <th class="column-title text-center">Masa Mesyuarat</th>
                        <th class="column-title text-center">Nama Mesyuarat</th>
                        <th class="column-title text-center">Tempat Mesyuarat</th>            
                        <th class="column-title text-center">Padam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($urusMesyuarat){
                    foreach ($urusMesyuarat as $admins) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $admins->kali_ke?></td>
                           <td><?= $admins->tarikhMesyuarat?></td>
                             <td><?= $date = date('h:i ', strtotime($admins['masa_mesyuarat']));?></td>
                             <td><?= $admins->nama_mesyuarat?></td>
                            <td><?= $admins->tempat_mesyuarat?></td>          
                             <td>
                             <?= Html::a('<i class="fa fa-trash-o"></i>', ['delete-urus-mesyuarat', 'id' => $admins->id], [
                                    'data' => [
                                 'confirm' => 'Adakah anda pasti untuk memadamnya?',
                                'method' => 'post',
                                    ],
                                ]) ?>
                            </td>
                    <?php }} ?>   
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


