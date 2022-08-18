<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Ln1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?php // echo $this->render('/tblrscoadminpost/_topmenu') ?>
<div class="row">
<div class="col-md-12 col-xs-12">
     <div class="x_panel">
         <div class="x_title">
            <h2><strong>Senarai Rekod Lantikan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
          <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Rekod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <div class="x_content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => 
            [
                'class' => 'table-responsive',
            ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [   'class' => 'kartik\grid\SerialColumn',
                'header' => 'Bil',
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],

//            'id',
            'ICNO',
//            [
//                'label' => 'NO IC',
//                'value' => 'ICNO',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'],
//            ],
            
            [
                'label' => 'Nama Staf',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            
//            'adminpos_id',
            [
                'label' => 'Jawatan Pentadbiran',
                'value' => 'displayadminpos.position_name',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
          
//            'jobStatus',
//             [
//                'label' => 'Status Jawatan',
//                'value' => 'displayjobstatus.jobstatus_desc',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'],
//            ],
            
//            'paymentStatus',
//            [
//                'label' => 'Status Bayaran',
//                'value' => 'displaypaymentstatus.paymentstatus_desc',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'],
//            ],
 
//            'description',
//            [
//                'label' => 'Catatan',
//                'value' => 'description',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'],
//            ],
            
//            'description_sef',
          
//            'dept_id',
            [
                'label' => 'JFPIB',
                'value' => 'displaydepartment.fullname',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            
//            'campus_id',
//            [
//                'label' => 'Kampus',
//                'value' => 'displaycampus.campus_name',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'],
//            ],
            
//            'appoinment_date',
//            'tarikhkuatkuasa',
            [
                'label' => 'Tarikh Kuatkuasa',
                'value' => 'tarikhkuatkuasa',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            
//            'start_date',
//            'tarikhmula',
            [
                'label' => 'Tarikh Lantikan',
                'value' => 'tarikhmula',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            
//            'end_date',
//            'tarikhtamat',
            [
                'label' => 'Tarikh Tamat',
                'value' => 'tarikhtamat',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
                        
//            'flag',
            [
                'label' => 'Status',
                'value' => 'displayflag.flagstatus',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ],
            
//            'files',
//            [
//                'label' => 'Files',
//                'value' => 'files',
//                'headerOptions' => ['class'=>'text-center'],
//                'contentOptions' => ['class'=>'text-center'],
//            ],
           
//            'renew',
            [
                'label' => 'Renew',
                'value' => 'displayrenew.renewstatus',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ], 
            
//            'status_tugas',
            [
                'label' => 'Status Tugas',
                'value' => 'displaytugasstatus.tugasstatus_desc',
                'headerOptions' => ['class'=>'text-center'],
                'contentOptions' => ['class'=>'text-center'],
            ], 

            ['class' => 'yii\grid\ActionColumn'],
            //['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'], 
        ],
    ]); ?>
        </div>
     </div>
</div>
</div>
