<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?> 
</div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Ahli Mesyuarat</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
     <div class="x_content">
         <div class="table-responsive">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($meetingbaru, 'icno')->label(false)->  widget(Select2::classname(), [
                    'data' => $allbiodata,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
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
</div>


<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Ahli Mesyuarat</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
             <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">NAMA</th>
                        <th class="column-title text-center">Padam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($meeting){
                    foreach ($meeting as $meetings) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $meetings->kakitangan->CONm; ?></td>
                                                <td>
        <?= Html::a('<i class="fa fa-trash-o"></i>', ['delete-meeting', 'id' => $meetings->id], [
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
