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
error_reporting(0); 

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Peribadi';
?>

<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/ptm/_topmenu'); ?> 
</div>
</div>

    <?php $form = ActiveForm::begin([
        'action' => ['halaman-utama'],
        'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >
<!--    <div class="x_panel" style="background-color:#b4c4d4;color:#37393b;">-->
    <div class="x_panel">
        <div class="x_title">
            <h2>Carian</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="form-group ">  
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?=
                    $form->field($carian, 'carian_kategorijawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ["1"=>"Akademik","2"=>"Pentadbiran"],
                        'options' => ['placeholder' => 'Kategori Jawatan', 'class' => 'form-control col-md-2 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                </div>
                
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
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?> 
                </div>  
                </div>
                
                <div class="form-group">  
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($carian, 'DeptId')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>     
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($carian, 'statLantikan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                        'options' => ['placeholder' => 'Status Lantikan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>  
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?=
                    $form->field($carian, 'Status')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                        'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-4 col-xs-12'],
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
            <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $model->getCount()." / ".$model->getTotalCount() ?></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style="width: 800px">No KP / Paspot</th>
                                <th style="width: 800px">UMSPER</th>
                                <th style="width: 800px">Nama Kakitangan</th>
                                <th style="width: 800px">Jabatan</th>
                                <th style="width: 800px">Status Lantikan</th>
                                <th style="width: 800px">Status</th>
                                <th class="text-center" style="width:auto">Tindakan</th>   
                            </tr>
                        </thead>   
                        <!--A-->

                        <?php
                        if (!empty($model)) {
                            
                            foreach ($model->getModels() as $data) {
                               
                                ?>
                                <tr>
                                    <td><?= $data->ICNO ?></td>
                                    <td><?= $data->COOldID ?></td>
                                    <td><?= $data->CONm ?></td>
                                    <td><?= $data->displayDepartment ?></td>
                                    <td><?= $data->displayStatusLantikan ?></td>
                                    <td><?= $data->displayServiceStatus ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['admin-view','id'=>$data->ICNO]) ?></td>  
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
</div>
