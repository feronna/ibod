<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use yii\db\Expression;
use dosamigos\datepicker\DatePicker;

?>
<?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary ']) ?>
</br>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Pengguna</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin([
                    'action' => ['batch-deletion'],
                    'method' => 'post',
                    'options' => ['class' => 'form-horizontal form-label-left']
                ]); ?>
                <div class="form-group">
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($model, 'title')->label(false)->widget(Select2::classname(), [
                                'data' => ['Paspot' => 'Paspot', 'Permit Kerja' => 'Permit Kerja'],
                                'options' => ['placeholder' => 'Jenis Notifikasi', 'class' => 'form-control col-md-2 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'ntf_dt',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?>
                    </div>
                    <div class=" col-md-1 col-sm-1 col-xs-12">
                        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Notifikasi</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                        <table class="table table-sm table-bordered jambo_table table-striped"> 
                            <thead>
                                <tr>
                                    <td>Jumlah Data</td>
                                    <td style="width:150px;">Tindakan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $total ?></td>
                                    <td><?= Html::a('<span class="glyphicon glyphicon-trash"></span> Delate All', ['batch-deletion'], ['class' => 'btn btn-primary ']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>