<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\tabs\TabsX;      
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="tblmaxtuntutan-search"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i> Butiran Peruntukan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <p>
                    <?= Html::a('Kembali Ke Laman Utama', ['carian'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kembali Ke Senarai Penambahan Peruntukan', ['senarai-topup'], ['class' => 'btn btn-success']) ?>
                </p>
                
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $rekod,
        'attributes' => [
                ['label' => 'No. K/P',
                'value' => $rekod->max_icno,
                'contentOptions' => ['style' => 'width:auto'],
                'captionOptions' => ['style' => 'width:26%'],],
                ['label' => 'Kelayakan Tahunan (RM)',
                'value' => $rekod->max_tuntutan],
                ['label' => 'Baki Peruntukan (RM)',
                'value' => $rekod->current_balance],                    
                ['label' => 'Jumlah Tuntutan Klinik Panel (RM)',
                'value' => $rekod->tuntutan],                    
                ['label' => 'Jumlah Tuntutan Klinik Bukan Panel (RM)',
                'value' => $rekod->tuntutan_bukan_panel],                    
                ['label' => 'Jumlah Tuntutan PKU HUMS - Sistem MedCare (RM)',
                'value' => $rekod->jumlah],                    
                ['label' => 'Jumlah Penambahan Peruntukan Terkini (RM)',
                'value' => $rekod->topup_max],                    
        ],
    ])
    ?>
    
  </div>
  <div class="x_title">
            <h2><i class="fa fa-plus"></i> Kemaskini Peruntukan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <?php
            $rekod->current_balance = "0.00";
            ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="clearfix"></div>   
        
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan Tahunan (RM)<span class="required"></span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?=
                    $form->field($rekod, 'max_tuntutan')->widget(NumberControl::classname(), [
                         'name' => 'max_tuntutan',
                           'pluginOptions'=>[
                           'initialize' => false,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Penambahan (RM)<span class="required"></span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?=
                    $form->field($rekod, 'topup_max')->widget(NumberControl::classname(), [
                         'name' => 'topup_max',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
                    </div>
<?php ActiveForm::end(); ?>
        </div>
  <div class="row">
        <div class="x_panel">
            <?php

           $items = [
                [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Senarai Lawatan Klinik Panel',
                    'content' => $this->render('_list_lawatan_admin', ['dataProvider'=>$dataProvider]),
                    'active' => true
                    
                ],
               [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Rawatan Klinik Bukan Panel',
                    'content' => $this->render('_list_bukanpanel', ['bukanpanels'=>$bukanpanels]),
                    'active' => false
                    
                ], 
               [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Lawatan PKU HUMS (Sistem MedCare)',
                    'content' => $this->render('_list_medcare', ['medcares'=>$medcares]),
                    'active' => false
                    
                ],
               [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Penambahan Peruntukan',
                    'content' => $this->render('_list_topup', ['bil' => 1, 'topup' => $topup,]),
                   
                ],
                
                  [
                    'label' => '<i class="fa fa-list"></i>&nbsp;Rekod Keluarga',
                    'content' => $this->render('_list_keluarga', ['bil' => 1, 'keluarga' => $keluarga,]),
                   
                ],                
            ];
            echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>

        </div>
  </div>
        </div>
    </div>
</div>
