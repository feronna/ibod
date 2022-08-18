<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Kontraktor: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4">  
                    <?php
                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->where(['>','DATE(tarikhtamatsah)',date('Y-m-d')])->all(), 'apsu_suppid', 'apsu_lname'),
                        'options' => ['placeholder' => 'Kontraktor', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\Kontraktor\SyarikatKontraktor::find()->all(), 'apsu_suppid', 'name'),
                        'options' => ['placeholder' => 'Kontraktor', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Sila Tunggu..']]) ?>
                </div>
            </div>
        </div>

    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Rekod Kenderaan Kontraktor</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  <br/>    
        <?php
        if ($record) {
            ?>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama Syarikat/Pemilik: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record, 'apsu_lname')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record, 'apsu_address1')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record, 'apsu_phone')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Emel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record, 'apsu_email')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?> 
        <?php ActiveForm::end(); ?><br/>   <br/>   
        <div class="table-responsive"> 
            <table class="table table-sm table-bordered jambo_table table-striped"> 

                <?php
                if ($record) {
                    $bil = 1;
                    ?>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">No Kenderaan</th>
                        <th class="text-center">Pemilikan</th>
                        <th class="text-center">Tarikh Tamat Lesen</th>
                        <th class="text-center">Tarikh Tamat Roadtax</th>
                        <th class="text-center">Tindakan</th> 
                    </tr>
                    <?php foreach ($record->kenderaan as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $bil; ?></td> 
                            <td class="text-center"><?= $l->reg_number ? $l->reg_number : ''; ?></td> 
                            <td class="text-center"><?= $l->rel_owner_user ? $l->rel_owner_user : ''; ?></td> 
                            <td class="text-center">
                                <?php
                                if ($l->lesen_exp) {
                                    if (date('Y-m-d') >= $l->lesen_exp) {
                                        echo '<span class="label label-danger">' . $l->lesen_exp . '</span>';
                                    } else {
                                        echo $l->lesen_exp;
                                    }
                                }
                                ?> 
                            </td> 
                            <td class="text-center"> 
                                <?php
                                if ($l->roadtax_exp) {
                                    if (date('Y-m-d') >= $l->roadtax_exp) {
                                        echo '<span class="label label-danger">' . $l->roadtax_exp . '</span>';
                                    } else {
                                        echo $l->roadtax_exp;
                                    }
                                }
                                ?>
                            </td> 
                            <td class="text-center"><?= Html::a('<i class="fa fa-edit"></i>', ['kemaskini-kenderaan-kontraktor', 'id' => $l->id], ['class' => 'btn btn-default btn-sm']); ?>

                                <?php
                                if ($model->checkhasApplied($l->id)) {
                                    echo Html::button('MOHON', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['mohon-kontraktor', 'id' => $model->id]), 'class' => 'mapBtn btn btn-primary btn-sm']);
                                } else {
                                    echo Html::a('MOHON', ['mohon-kontraktor', 'id' => $l->id], ['class' => 'btn btn-primary btn-sm']);
                                }
                                ?>
                            </td> 
                        </tr>

                        <?php
                        $bil++;
                    }
                }
                ?>
            </table>
        </div> 
    </div>
    
    <div class="x_panel">
    <div class="table-responsive">     
        
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Nama Pekerja', 
                'value' => 'CONm',
            ],
            //  [
            //     'label' => 'No.Permit',
            //     'value' => 'no_permit',
            // ],
            [
                'label' => 'No. K/P',
                'value' => 'ICNO',
            ],
           
            
           
            [
                'label' => '',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                             
                        return  
                        Html::a('<i class="fa fa-eye">', ["kontraktor/perincian-pekerja", 'id' => $list->id]);
                          
                           
                        
                      },
            ], 
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'beforeHeader' => [
                [
                    'columns' => [],
                    'options' => ['class' => 'skip-export'] // remove this row from export
                ]
            ],
            'toolbar' => [
//                '{export}',
//                '{toggleData}'
            ],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<h2>Maklumat Pekerja</h2>',
            ],
        ]);
        ?>
       
    </div>
</div>  
</div> 
