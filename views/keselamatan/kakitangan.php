<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use yii\widgets\LinkPager;
use app\widgets\TopMenuWidget;
use yii\helpers\Url;;
error_reporting(0); 

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Peribadi';
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="tblprcobiodata-form" >

    <?php $form = ActiveForm::begin([
        'action' => ['kakitangan'],
        'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>

    <div class="x_panel" style="background-color:#b4c4d4;color:#37393b;">
        <div class="x_title">
            <h2>Carian</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group ">
                <div class="form-group">
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?=
                    $form->field($carian, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                        'data' => ["0"=>"IC","1"=>"Nama","2"=>"UMSPER"],
                        'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                </div>
                <div class=" col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($carian, 'carian_data')->textInput(['placeholder'=>'Nama / Nombor IC / ID'])->label(false) ?> 
                </div>
                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
                
                </div>
                <div class="form-group">
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($carian, 'carian_department')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->where(['id'=>['2','33','139']])->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12','value'=>2,'selected'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($carian, 'carian_statuslantikan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                        'options' => ['placeholder' => 'Status Lantikan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
          
                 </div>
            </div>           
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>


<div class="col-md-12 col-sm-12 col-xs-12 " > 
    <div class="x_panel">
        <div class="x_title" style="color:#37393b;">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style="width:auto">Bil</th>
                                <th style="width: 400px">UMSPER</th>
                                <th style="width: 800px">Nama Kakitangan</th>
                                <th style="width: 800px">Gred</th>
                                <th style="width: 800px">Jabatan</th>
                                <th style="width: 800px">Status Lantikan</th>
<!--                                <th style="width: 800px">Pendidikan Tertinggi</th>-->
                                <!--<th class="text-center" style="width:auto">Tindakan</th>-->   
                                <th class="text-center" style="width:auto">Tindakan Bertulis/Lisan</th>   
                            </tr>
                        </thead>   
                        <!--A-->

                        <?php
                        if (!empty($model)) {
                            
                            foreach ($model->getModels() as $data) {
                               
                                ?>
                                <tr>
                                    <td><?= $bil++ ?></td>
                                    <td><?= $data->COOldID ?></td>
                                    <td><?= $data->CONm ?></td>
                                    <td><?= $data->jawatan->gred ?></td>
                                    <td><?= $data->displayDepartment ?></td>
                                    <td><?= $data->displayStatusLantikan ?></td>
                                    <!--<td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminview','id'=>$data->ICNO]) ?></td>-->  
                                    <td class="text-center"><?= Html::button('<i class="fa fa-pencil"></i>', ['value' => Url::to(['keselamatan/tindakan-bertulis', 'id' => $data->ICNO]), 'class' => 'mapBtn', 'id' => 'modalButton']);?></td>  
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="9">No Data.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
                echo LinkPager::widget([
                    'pagination' => $model->pagination,
                    
                ]);
            ?>
        </div>
    </div>
</div>
