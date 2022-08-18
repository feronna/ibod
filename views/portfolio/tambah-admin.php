<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
$statusLabel = [
        1 => '<span class="label label-warning">Admin</span>',
        2 => '<span class="label label-info">Ketua Pentadbiran</span>',
        3 => '<span class="label label-info">Auditor</span>',
];
?>


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah Admin</strong></h2>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan<span class="required" style="color:red;">*</span></label>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($adminbaru, 'icno')->label(false)->  widget(Select2::classname(), [
                    'data' => $allbiodata,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
              
                      <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Akses<span class="required" style="color:red;">*</span></label>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                  <?=
                $form->field($adminbaru, 'jenis_akses')->label(false)->  widget(Select2::classname(), [
                    'data' => [1 => 'Admin', 3 =>'Auditor' , 2 => 'Ketua Pentadbiran'],
                    'options' => ['placeholder' => 'Pilih Jenis Akses', 'class' => 'form-control col-md-7 col-xs-12'],
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
            <h2><strong>Senarai Admin</strong></h2>
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
                        <th class="column-title text-center">JENIS AKSES</th>
                        <th class="column-title text-center">Padam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($admin){
                    foreach ($admin as $admins) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $admins->kakitangan->CONm; ?></td>
                           <td><?= $statusLabel[$admins->jenis_akses] ?></td>
                                                <td>
        <?= Html::a('<i class="fa fa-trash-o"></i>', ['delete-admin', 'id' => $admins->id], [
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

