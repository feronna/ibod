<?php
use kartik\number\NumberControl;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,211], 'vars' => []]); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemasikini Kemudahan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
                
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
          <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jenis Kemudahan</th>
                        <td>
                            <?= $model->kemudahan; ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Kod Akaun</th>
                        <td> 
                         <?= $akaun->kodAkaun;?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jumlah</th>
                        <td>
                         <?= $model->jumlah; ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jumlah Keseluruhan Kemudahan</th>
                        <td>
                        <?= $model->amount; ?>
                        </td> 
                    </tr>
                     
                </table>
            </div> 
    </div>
    </div> 
</div>
<?php ActiveForm::end(); ?>

 

